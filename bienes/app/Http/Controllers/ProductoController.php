<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // return view('producto.index');
        $datos['productos'] = Producto::paginate(5);
        return view('producto.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('producto.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $campos = [
            'sArticulo'=>'required|string|max:255',
            'sDescripcion'=>'required|string|max:255',
            'sFoto'=>'required|max:10000|mimes:jpeg,png,jpeg,gif'
        ];
        $mensaje = [
            // 'required'=>'El campo :attribute es requerido',
            'sArticulo.required' => 'El nombre del articulo es requerido',
            'sDescripcion.required' => 'La descripcion del articulo es requerido',
            'sFoto.required' => 'La foto del articulo es requerida'

        ];

        $this->validate($request, $campos, $mensaje);

        // $datosProducto = request()->all();
        $datosProducto = request()->except('_token');

        if ($request->hasFile('sFoto')) {
            $datosProducto['sFoto'] = $request->file('sFoto')->store('uploads', 'public');
        }

        Producto::insert($datosProducto);
        //return response()->json($datosProducto);
        return redirect('producto')->with('mensaje', 'Producto agregado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $producto = Producto::findOrFail($id);
        return view('producto.edit', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $campos = [
            'sArticulo' => 'required|string|max:255',
            'sDescripcion' => 'required|string|max:255',
        ];
        $mensaje = [
            // 'required' => 'El campo :attribute es requerido',
            'sArticulo.required' => 'El nombre del articulo es requerido',
            'sDescripcion.required' => 'La descripcion del articulo es requerido',

        ];
        if ($request->hasFile('sFoto')) {
                $campos = ['Foto' => 'required|max:10000|mimes:jpeg,png,jpeg,gif'];
                $mensaje = ['Foto.required' => 'La foto del articulo es es requerida'];
            }

        $this->validate($request, $campos, $mensaje);
        //
        $datosProducto = request()->except('_token', '_method');

        if ($request->hasFile('sFoto')) {
            $producto = Producto::findOrFail($id);

            Storage::delete('public/' . $producto->sFoto);

            $datosProducto['sFoto'] = $request->file('sFoto')->store('uploads', 'public');
        }

        Producto::where('id', '=', $id)->update($datosProducto);
        $producto = Producto::findOrFail($id);

        return redirect('producto')->with('mensaje', 'Producto Modificado correctamente');
        // return view('producto.edit', compact('producto'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $producto = Producto::findOrFail($id);

        if (Storage::delete('public/' . $producto->sFoto)) {
            Producto::destroy($id);
        }

        // return redirect('producto');
        return redirect('producto')->with('mensaje', 'Producto Eliminado correctamente');
    }
}
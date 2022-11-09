<!-- mostrar listado de productos :D -->
@extends('layouts.app')
@section('content')
<div class="container">

  @if(Session::has('mensaje'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ Session::get('mensaje') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif

  <a href="{{ url('producto/create') }}" class="btn btn-success">Registrar Nuevo Producto</a>
  <br>
  <br>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-light">
            <thead>
              <tr>
                <th scope="col" style="width:15%;">Acciones</th>
                <th scope="col" style="width:20%;">Producto</th>
                <th scope="col" style="width:35%;">Descripcion</th>
                <th scope="col" style="width:15%;">Foto</th>
              </tr>
            </thead>
            <tbody>
              @foreach($productos as $producto)
              <tr>
                <td>

                  <a href="{{ url('/producto/'.$producto->id.'/edit') }}" class="btn btn-primary">
                    Editar
                  </a>

                  <form action="{{ url('/producto/'.$producto->id) }}" class="d-inline" method="post">
                    @csrf
                    {{method_field('DELETE')}}
                    <input type="submit" onclick="return confirm('¿Esta seguro de eliminar el registro?')"
                      value="Borrar" class="btn btn-danger">
                  </form>
                </td>
                <td>{{$producto->sArticulo}}</td>
                <td>{{$producto->sDescripcion}}</td>
                <td><img class="img-thumbnail img-fuild" src="{{ asset('storage').'/'.$producto->sFoto }}" width="100"
                    alt="">
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          {!! $productos->links() !!}
        </div>
      </div>
    </div>
  </div>
  @endsection
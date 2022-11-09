<!-- formulario que tendra los datos en comun con create y edit -->

<h1> {{$modo}} Producto</h1>

@if(count($errors)>0)
    <div class="alert alert-danger" role="alert">
<ul>
        @foreach( $errors->all() as $error)
            <li> {{ $error }} </li>
        @endforeach
</ul>
    </div>
@endif

<div class="form-group">

    <br>
    <label>Nombre del Producto</label>
    <input type="text" class="form-control" name="sArticulo"
        value="{{ isset($producto->sArticulo)?$producto->sArticulo: old('sArticulo') }}" id="sArticulo">

</div>
<div class="form-group">
    <label>Descripcion del Producto</label>
    <input type="text" class="form-control" name="sDescripcion"
        value="{{ isset($producto->sDescripcion)?$producto->sDescripcion: old('sDescripcion') }}" id="sDescripcion">

</div>
<br>
<div class="form-group">
    <label for="sFoto">Foto del Producto</label>
    @if(isset($producto->sFoto))
    <img class="img-thumbnail img-fuild" src="{{ asset('storage').'/'.$producto->sFoto }}" width="100" alt="">
    <br>
    <br>
    @endif
    <input type="file" class="form-control img-thumbnail img-fuild" name="sFoto" value="" id="sFoto">
</div>
<br>
<a href="{{ url('producto') }}" class="btn btn-danger">Cancelar</a>

<input type="submit" value="{{$modo}}" class="btn btn-success">
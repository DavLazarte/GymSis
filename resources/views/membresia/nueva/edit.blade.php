@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Membresia: {{ $membresia->tipo}}</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif

			{!!Form::model($membresia,['method'=>'PATCH','route'=>['membresia.nueva.update',$membresia->idmembresia]])!!}
            {{Form::token()}}
            <div class="form-group">
            	<label for="nombre">Nombre</label>
            	<input type="text" name="tipo" class="form-control" value="{{$membresia->tipo}}">
            </div>
            <div class="form-group">
            	<label for="duracion">Duracion</label>
            	<input type="text" name="duracion" class="form-control" value="{{$membresia->duracion}}">
            </div>
            <div class="form-group">
            	<label for="precio">Precio</label>
            	<input type="text" name="precio" class="form-control" value="{{$membresia->precio}}">
            </div>
            <div class="form-group">
            	<button class="btn btn-primary" type="submit">Guardar</button>
            	<button class="btn btn-danger" type="reset">Cancelar</button>
            </div>

			{!!Form::close()!!}		
            
		</div>
	</div>
@push ('scripts')
<script>
$('#liAlmacen').addClass("treeview active");
$('#liCategorias').addClass("active");
</script>
@endpush
@endsection
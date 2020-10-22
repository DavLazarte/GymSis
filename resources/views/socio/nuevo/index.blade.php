@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de Socios <a href="nuevo/create"><button class="btn btn-success">Nuevo</button></a> <a href="{{url('reporteclientes')}}" target="_blank"><button class="btn btn-info">Reporte</button></a></h3>
		@include('socio.nuevo.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Id</th>
					<th>Nombre</th>
					<th>Teléfono</th>
					<th>Codigo</th>
					<th>Domicilio</th>
					<th>Imagen</th>
					<th>Estado</th>
					<th>Opciones</th>
				</thead>
               @foreach ($socios as $soc)
				<tr>
					<td>{{ $soc->idsocio}}</td>
					<td>{{ $soc->nombre}}</td>
					<td>{{ $soc->codigo}}</td>
					<td>{{ $soc->telefono}}</td>
					<td>{{ $soc->direccion}}</td>
					<td>
						<img src="{{asset('imagenes/socios/'.$soc->imagen)}}" alt="{{ $soc->nombre}}" height="100px" width="100px" class="img-thumbnail">
					</td>
					<td>{{ $soc->estado}}</td>
					<td>
						<a href="{{URL::action('SocioController@edit',$soc->idsocio)}}"><button class="btn btn-info">Editar</button></a>
                         <a href="" data-target="#modal-delete-{{$soc->idsocio}}" data-toggle="modal"><button class="btn btn-danger">Eliminar</button></a>
					</td>
				</tr>
				@include('socio.nuevo.modal')
				@endforeach
			</table>
		</div>
		{{$socios->render()}}
	</div>
</div>
@push ('scripts')
<script>
$('#liVentas').addClass("treeview active");
$('#liClientes').addClass("active");
</script>
@endpush
@endsection
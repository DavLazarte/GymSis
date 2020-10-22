@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Salidas<a href="salida/create"><button class="btn btn-success">Nuevo</button></a> <a href="{{url('reporteotro')}}" target="_blank"><button class="btn btn-info">Reporte</button></a></h3>
		@include('administracion.salida.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Fecha</th>
					<th>Monto</th>
					<th>Destino</th>
					<th>Descripción</th>
					<th>Opciones</th>
				</thead>
               @foreach ($salidas as $sal)
				<tr>
					<td>{{ Carbon\Carbon::parse($sal->created_at)->format('d-m-Y') }}</td>
					<td>{{ $sal->monto}}</td>
					<td>{{ $sal->destino}}</td>
					<td>{{ $sal->descripcion}}</td>
					<td>
						<a href="{{URL::action('SalidaController@edit',$sal->idsalida)}}"><button class="btn btn-primary">Editar</button></a>
                         <a href="" data-target="#modal-delete-{{$sal->idsalida}}" data-toggle="modal"><button class="btn btn-danger">Anular</button></a>
					</td>
				</tr>
				@include('administracion.salida.modal')
				@endforeach
			</table>
		</div>
		{{$salidas->render()}}
	</div>
</div>
@push ('scripts')
<script>
$('#liotrpras').addClass("treeview active");
$('#liIngresos').addClass("active");
</script>
@endpush
@endsection
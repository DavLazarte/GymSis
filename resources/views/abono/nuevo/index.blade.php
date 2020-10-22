@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Abonos <a href="nuevo/create"><button class="btn btn-success">Nuevo</button></a> <a href="{{url('reporteotro')}}" target="_blank"><button class="btn btn-info">Reporte</button></a></h3>
		@include('abono.nuevo.search')
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Inicio</th>
					<th>Socio</th>
					<th>Membresia</th>
					<th>Vencimiento</th>
					<th>Estado</th>
					<th>Opciones</th>
				</thead>
               @foreach ($abonos as $abn)
				<tr>
					<td>{{ Carbon\Carbon::parse($abn->created_at)->format('d-m-Y') }}</td>
					<td>{{ $abn->idsocio.-.$abn->}}</td>
					<td>{{ $abn->idmembresia}}</td>
					<td>{{ Carbon\Carbon::parse($abn->vencimiento)->format('d-m-Y') }}</td>
					<td>{{ $abn->estado}}</td>
					<td>
						<a href="{{URL::action('AbonoController@edit',$abn->idabono)}}"><button class="btn btn-primary">Renovar</button></a>
                         <a href="" data-target="#modal-delete-{{$abn->idabono}}" data-toggle="modal"><button class="btn btn-danger">Anular</button></a>
					</td>
				</tr>
				@include('abono.nuevo.modal')
				@endforeach
			</table>
		</div>
		{{$abonos->render()}}
	</div>
</div>
@push ('scripts')
<script>
$('#liotrpras').addClass("treeview active");
$('#liIngresos').addClass("active");
</script>
@endpush
@endsection
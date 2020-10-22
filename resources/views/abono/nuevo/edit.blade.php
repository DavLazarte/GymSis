@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Ingreso: {{ Carbon\Carbon::parse($ingreso->created_at)->format('d-m-Y') }}</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif
		</div>
	</div>
			{!!Form::model($ingreso,['method'=>'PATCH','route'=>['administracion.ingreso.update',$ingreso->idingreso]])!!}
            {{Form::token()}}
     <div class="row">
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="origen">Origen</label>
                <input type="text" name="origen" required value="{{$ingreso->origen}}" class="form-control">
            </div>
        </div>
        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label for="abono">Abono</label>
                <select name="abono" class="form-control selectpicker" data-live-search="true">
                    @foreach($abono as $abo)
                     <option value="{{$ingreso->abono}}">{{$ingreso->abono.'-'. $abo->nombre}}</option>
                     @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="monto">Monto</label>
                <input type="text" name="monto" required value="{{$ingreso->monto}}" class="form-control">
            </div>
        </div>
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="detalle">Detalle</label>
                <input type="text" name="detalle" required value="{{$ingreso->detalle}}" class="form-control" >
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <button class="btn btn-danger" type="reset">Cancelar</button>
            </div>
        </div>
    </div>
{!!Form::close()!!}		           
@push ('scripts')
<script>
$('#liAlmacen').addClass("treeview active");
$('#liArticulos').addClass("active");
</script>
@endpush
@endsection
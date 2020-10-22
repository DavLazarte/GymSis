@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Socio: {{ $socio->nombre}}</h3>
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
			{!!Form::model($socio,['method'=>'PATCH','route'=>['socio.nuevo.update',$socio->idsocio]])!!}
            {{Form::token()}}
    <div class="row">
        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" required value="{{$socio->nombre}}" class="form-control">
            </div>
        </div>
        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label for="telefono">Telefono</label>
                <input type="number" name="telefono" required value="{{$socio->telefono}}" class="form-control">
            </div>
        </div>
        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label for="direccion">Dirreción</label>
                <input type="text" name="direccion" required value="{{$socio->direccion}}" class="form-control">
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="codigo">Código</label>
                <input type="text" name="codigo" id="codigobar" required value="{{$socio->codigo}}" class="form-control">
                <br>
               <button class="btn btn-success" type="button" onclick="generarBarcode()">Generar</button>
                <button class="btn btn-info" onclick="imprimir()"type="button">imprimir</button>
                <div id="print">
                    <svg id="barcode"></svg>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="imagen">Imagen</label>
                <input type="file" name="imagen" class="form-control">
                @if(($socio->imagen)!="")
                <img src="{{asset('imagenes/socios/'.$socio->imagen)}}" height="300px" width="300px">
                @endif
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <button class="btn btn-danger" type="reset">Cancelar</button>
            </div>
        </div>
    </div>   
{!!Form::close()!!}		
            
@push ('scripts')
<script src="{{asset('js/JsBarcode.all.min.js')}}"></script>
<script src="{{asset('js/jquery.PrintArea.js')}}"></script>
<script>
function generarBarcode()
{   
    codigo=$("#codigobar").val();
    JsBarcode("#barcode", codigo, {
    format: "EAN13",
    font: "OCRB",
    fontSize: 18,
    textMargin: 0
    });
}
$('#liAlmacen').addClass("treeview active");
$('#liArticulos').addClass("active");


//Código para imprimir el svg
function imprimir()
{
    $("#print").printArea();
}
generarBarcode();
</script>
@endpush
@endsection
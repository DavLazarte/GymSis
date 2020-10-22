@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h3>Nuevo Abono</h3>
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
            {!!Form::open(array('url'=>'abono/nuevo','method'=>'POST','autocomplete'=>'off','files'=>'true'))!!}
            {{Form::token()}}
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="socio">Elegir Socio</label>
                <select  class="form-control selectpicker" data-live-search="true" id="psocio">
                    @foreach($socio as $soc)
                     <option value="{{$soc->idsocio}}_{{$soc->idsocio}}_{{$soc->codigo}}">{{$soc->idsocio.'-'. $soc->nombre}}</option>
                     @endforeach
                </select>
            </div>
        </div>
        <input type="hidden" id="pidsocio" name="idsocio" value="">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="idmembresia">Elegir Membresia</label>
                <select class="form-control selectpicker" data-live-search="true" id="pmembresia">
                    @foreach($membresia as $mem)
                     <option value="{{$mem->idmembresia}}_{{$mem->precio}}_{{$mem->duracion}}">{{$mem->idmembresia.'-'. $mem->tipo}}</option>
                     @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="codigo">Codigo Socio</label>
                <input type="text" name="codigosocio" required class="form-control" value="" id="pcodigo">
            </div>
        </div>
        
        <input type="hidden" name="idmembresia" id="pidmembresia" value="">
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="precio">Precio</label>
                <input type="text" name="precio" required class="form-control" value="" id="pprecio">
            </div>
        </div>
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="disponible">Dias Disponibles</label>
                <input type="text" name="disponible" required class="form-control" value="0" id="pdisponible">
            </div>
        </div>
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="vencimiento">Vencimiento</label>
                <input type="date" name="vencimiento" required class="form-control">
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

$("#psocio").change(mostrarSocio);
$("#pmembresia").change(mostrarMembresia);

function mostrarSocio(){
    datos=document.getElementById('psocio').value.split('_');
    $("#pidsocio").val(datos[0]);
    $("#pcodigo").val(datos[2]);
}
function mostrarMembresia(){
    datosm=document.getElementById('pmembresia').value.split('_');
    $("#pidmembresia").val(datosm[0]);
    $("#pprecio").val(datosm[1]);
    $("#pdisponible").val(datosm[2]);
}
$('#liAlmacen').addClass("treeview active");
$('#liArticulos').addClass("active");
</script>
@endpush
@endsection
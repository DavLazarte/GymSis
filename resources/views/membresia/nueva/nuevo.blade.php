<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-nuevor">
    {!!Form::open(array('url'=>'deposito/rubro','method'=>'POST','autocomplete'=>'off'))!!}
    {{Form::token()}}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
           <div class="modal-header">
              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <h3>Nuevo Rubro</h3>
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
        </div>
    <div class="modal-body">
        <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" class="form-control" placeholder="Nombre...">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <input type="text" name="descripcion" class="form-control" placeholder="Descripción...">
            </div>
        </div>

    </div>
    </div>
    <div class="modal-footer">
        <div class="form-group">
            <button class="btn btn-primary" type="submit">Guardar</button>
            <button class="btn btn-danger" type="reset" data-dismiss="modal">Cancelar</button>
        </div>
    </div>
</div>
</div>   
{!!Form::close()!!} 
@push ('scripts')
<script>

$('#liVentas').addClass("treeview active");
$('#liVentass').addClass("active");
  
</script>


@endpush    
</div>
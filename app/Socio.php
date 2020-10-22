<?php

namespace GymSis;

use Illuminate\Database\Eloquent\Model;

class Socio extends Model
{
	protected $table='socio';

    protected $primaryKey='idsocio';

    public $timestamps=true;


    protected $fillable =[
    	'nombre',
    	'telefono',
    	'direccion',
    	'telefono',
        'codigo',
    	'imagen',
    	'estado'
    ];

    protected $guarded =[

    ];    
}

<?php

namespace GymSis;

use Illuminate\Database\Eloquent\Model;

class Salida extends Model
{
    protected $table='salida';

    protected $primaryKey='idsalida';

    public $timestamps=true;


    protected $fillable =[
    	'monto',
    	'destino',
    	'descripcion',
    	'estado'
    ];

    protected $guarded =[

    ];
}

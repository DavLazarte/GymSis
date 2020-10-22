<?php

namespace GymSis;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $table='ingreso';

    protected $primaryKey='idingreso';

    public $timestamps=true;


    protected $fillable =[
    	'origen',
    	'abono',
    	'monto',
    	'detalle',
    	'estado'
    ];

    protected $guarded =[

    ];
}

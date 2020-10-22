<?php

namespace GymSis;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $table='movimiento';

    protected $primaryKey='idmovimiento';

    public $timestamps=true;


    protected $fillable =[
    	'abono',
    	'socio',
    	'monto',
    	'estado'
    ];

    protected $guarded =[

    ];
}

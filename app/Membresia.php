<?php

namespace GymSis;

use Illuminate\Database\Eloquent\Model;

class Membresia extends Model
{
    protected $table='membresia';

    protected $primaryKey='idmembresia';

    public $timestamps=true;


    protected $fillable =[
    	'tipo',
    	'duracion',
    	'precio',
    	'estado'
    ];

    protected $guarded =[

    ];
}

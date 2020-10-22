<?php

namespace GymSis;

use Illuminate\Database\Eloquent\Model;

class Abono extends Model
{
    protected $table='abono';

    protected $primaryKey='idabono';

    public $timestamps=true;


    protected $fillable =[
    	'idsocio',
        'codigosocio',
    	'idmembresia',
    	'vencimiento',
        'precio',
        'disponible',
    	'estado'
    ];

    protected $guarded =[

    ];
}

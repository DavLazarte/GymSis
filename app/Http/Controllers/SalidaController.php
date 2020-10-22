<?php

namespace GymSis\Http\Controllers;

use Illuminate\Http\Request;

use GymSis\Http\Requests;

use GymSis\Salida;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use GymSis\Http\Requests\SalidaFormRequest;
use DB;
use Response;
use Illuminate\Support\Collection;

class SalidaController extends Controller
{
 public function index(Request $request)
    {
        if ($request)
        {
            $query=trim($request->get('searchText'));
            $salidas=DB::table('salida')
            ->select('idsalida','monto','destino','descripcion','created_at','estado')
            ->where('destino','LIKE','%'.$query.'%')
            ->where('estado','=','Activo')
            ->orwhere('created_at','LIKE','%'.$query.'%')
            ->where('estado','=','Activo')
            ->orderBy('idsalida','asc')
            ->paginate(7);
            return view('administracion.salida.index',["salidas"=>$salidas,"searchText"=>$query]);
        }
    }
    public function create()
    {
    	
        return view("administracion.salida.create");
    }
    public function store (SalidaFormRequest $request)
    {
        $salida=new Salida;
        $salida->monto=$request->get('monto');
        $salida->destino=$request->get('destino');
        $salida->descripcion=$request->get('descripcion');
        $salida->estado='Activo';
        $salida->save();
        return Redirect::to('administracion/salida');

    }
    public function edit($id)
    {
        $salida=Salida::findOrFail($id);
        return view("administracion.salida.edit",["salida"=>$salida]);
    }
    public function update(SalidaFormRequest $request,$id)
    {
       
        $salida=Salida::findOrFail($id);
        $salida->monto=$request->get('monto');
        $salida->destino=$request->get('destino');
        $salida->descripcion=$request->get('descripcion');
        $salida->update();
        return Redirect::to('administracion/salida');
    }

    public function destroy($id){
        $salida=Salida::findOrFail($id);
        $salida->estado='Eliminado';
        $salida->update();
        return Redirect::to('administracion/salida');

    }
    public function reporte(){
         //Obtenemos los registros
         $registros=DB::table('otro_ingreso')
            ->orderBy('idingreso','asc')
            ->get();

         $pdf = new Fpdf();
         $pdf::AddPage();
         $pdf::SetTextColor(35,56,113);
         $pdf::SetFont('Arial','B',11);
         $pdf::Cell(0,10,utf8_decode("Listado de Ingresos"),0,"","C");
         $pdf::Ln();
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(206, 246, 245); // establece el color del fondo de la celda 
         $pdf::SetFont('Arial','B',10); 
         //El ancho de las columnas debe de sumar promedio 190        
         $pdf::cell(20,8,utf8_decode("Fecha"),1,"","L",true);
         $pdf::cell(40,8,utf8_decode("Origen"),1,"","L",true);
         $pdf::cell(40,8,utf8_decode("Monto"),1,"","L",true);
         $pdf::cell(60,8,utf8_decode("Concepto"),1,"","L",true);
  
         
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(255, 255, 255); // establece el color del fondo de la celda
         $pdf::SetFont("Arial","",9);
         
         foreach ($registros as $reg)
         {
            $pdf::cell(20,6,substr($reg->fecha_hora,0,10),1,"","L",true);
            $pdf::cell(40,6,utf8_decode($reg->origen),1,"","L",true);
            $pdf::cell(40,6,utf8_decode($reg->monto),1,"","L",true);
            $pdf::cell(60,6,utf8_decode($reg->concepto),1,"","L",true);       
            $pdf::Ln(); 
         }

         $pdf::Output();
         exit;
    }
}

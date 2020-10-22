<?php

namespace GymSis\Http\Controllers;

use Illuminate\Http\Request;

use GymSis\Http\Requests;

use GymSis\Ingreso;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use GymSis\Http\Requests\IngresoFormRequest;
use DB;
use Response;
use Illuminate\Support\Collection;

class IngresoController extends Controller
{
    public function index(Request $request)
    {
        if ($request)
        {
            $query=trim($request->get('searchText'));
            $ingresos=DB::table('ingreso')
            ->select('idingreso','origen','abono','monto','detalle','created_at','estado')
            ->where('origen','LIKE','%'.$query.'%')
            ->where('estado','=','Activo')
            ->orwhere('created_at','LIKE','%'.$query.'%')
            ->where('estado','=','Activo')
            ->orderBy('idingreso','asc')
            ->paginate(7);
            return view('administracion.ingreso.index',["ingresos"=>$ingresos,"searchText"=>$query]);
        }
    }
    public function create()
    {
    	$abono=DB::table('abono as a')
    	->join('socio as s','a.idsocio','=','s.idsocio')
    	->select('a.idabono','s.nombre')
    	->get();
        return view('administracion.ingreso.create',["abono"=>$abono]);
    }
    public function store (IngresoFormRequest $request)
    {
        $ingreso=new Ingreso;
        $ingreso->origen=$request->get('origen');
        $ingreso->abono=$request->get('abono');
        $ingreso->monto=$request->get('monto');
        $ingreso->detalle=$request->get('detalle');
        $ingreso->estado='Activo';
        $ingreso->save();
        return Redirect::to('administracion/ingreso');

    }
    public function show($id)
    {
        return view("administracion.ingreso.show",["ingresos"=>Ingreso::findOrFail($id)]);
    }
    public function edit($id)
    {
        $ingreso=Ingreso::findOrFail($id);
        return view("administracion.ingreso.edit",["ingreso"=>$ingreso]);
    }
    public function update(IngresoFormRequest $request,$id)
    {
       
        $ingreso=Ingreso::findOrFail($id);
        $ingreso->origen=$request->get('origen');
        $ingreso->abono=$request->get('abono');
        $ingreso->monto=$request->get('monto');
        $ingreso->detalle=$request->get('detalle');
        $ingreso->update();
        return Redirect::to('administracion/ingreso');
    }

    public function destroy($id){
        $ingreso=Ingreso::findOrFail($id);
        $ingreso->estado='Eliminado';
        $ingreso->update();
        return Redirect::to('administracion/ingreso');

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

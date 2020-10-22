<?php

namespace GymSis\Http\Controllers;

use Illuminate\Http\Request;

use GymSis\Http\Requests;

use GymSis\Abono;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use GymSis\Http\Requests\AbonoFormRequest;
use DB;
use Response;
use Illuminate\Support\Collection;

class AbonoController extends Controller
{
     public function index(Request $request)
    {
        if ($request)
        {
            $query=trim($request->get('searchText'));
            $abonos=DB::table('abono')
            ->join()
            ->select('idabono','idsocio','codigosocio','idmembresia','vencimiento','precio','created_at','disponible','estado')
            ->where('idsocio','LIKE','%'.$query.'%')
            
            ->where('codigosocio','LIKE','%'.$query.'%')
            
            ->orwhere('created_at','LIKE','%'.$query.'%')
            
            ->orwhere('idabono','LIKE','%'.$query.'%')
         
            ->orderBy('idabono','asc')
            ->paginate(7);
            return view('abono.nuevo.index',["abonos"=>$abonos,"searchText"=>$query]);
        }
    }
    public function create()
    {
    	$socio=DB::table('socio')
    	->select('idsocio','nombre','codigo')
    	->get();
    	$membresia=DB::table('membresia')
    	->select('idmembresia','tipo','precio','duracion')
    	->get();
        return view('abono.nuevo.create',["socio"=>$socio,"membresia"=>$membresia]);
    }
    public function store (AbonoFormRequest $request)
    {
        $abono=new Abono;
        $abono->idsocio=$request->get('idsocio');
        $abono->codigosocio=$request->get('codigosocio');
        $abono->idmembresia=$request->get('idmembresia');
        $abono->vencimiento=$request->get('vencimiento');
        $abono->precio=$request->get('precio');
        $abono->disponible=$request->get('disponible');
        $abono->estado='Pendiente';
        $abono->save();
        return Redirect::to('abono/nuevo');

    }
    public function show($id)
    {
        return view("abono.nuevo.show",["abonos"=>Abono::findOrFail($id)]);
    }
    public function edit($id)
    {
        $abono=Abono::findOrFail($id);
        return view("abono.nuevo.edit",["abono"=>$abono]);
    }
    public function update(AbonoFormRequest $request,$id)
    {
       
        $abono=Abono::findOrFail($id);
      	$abono->idsocio=$request->get('idsocio');
        $abono->codigosocio=$request->get('codigosocio');
        $abono->idmemebresia=$request->get('idmembresia');
        $abono->vencimiento=$request->get('vencimiento');
        $abono->precio=$request->get('precio');
        $abono->disponible=$request->get('disponible');
        $abono->update();
        return Redirect::to('abono/nuevo');
    }

    public function destroy($id){
        $abono=Abono::findOrFail($id);
        $abono->estado='Vencido';
        $abono->update();
        return Redirect::to('abono/nuevo');

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

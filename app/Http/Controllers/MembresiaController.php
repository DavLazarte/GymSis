<?php

namespace GymSis\Http\Controllers;

use Illuminate\Http\Request;

use GymSis\Http\Requests;
use GymSis\Membresia;
use Illuminate\Support\Facades\Redirect;
use GymSis\Http\Requests\MembresiaFormRequest;
use DB;
use Fpdf;

class MembresiaController extends Controller
{
    public function index(Request $request)
    {
        if ($request)
        {
            $query=trim($request->get('searchText'));
            $membresias=DB::table('membresia')->where('tipo','LIKE','%'.$query.'%')
            ->where ('estado','=','Disponible')
            ->orderBy('idmembresia','desc')
            ->paginate(7);
            return view('membresia.nueva.index',["membresias"=>$membresias,"searchText"=>$query]);
        }
    }
    public function create()
    {
        return view("membresia.nueva.create");
    }
    public function store (MembresiaFormRequest $request)
    {
        $membresia=new Membresia;
        $membresia->tipo=$request->get('tipo');
        $membresia->duracion=$request->get('duracion');
        $membresia->precio=$request->get('precio');
        $membresia->estado='Disponible';
        $membresia->save();
        return Redirect::to('membresia/nueva');

    }
    public function edit($id)
    {
        return view("membresia.nueva.edit",["membresia"=>Membresia::findOrFail($id)]);
    }
    public function update(MembresiaFormRequest $request,$id)
    {
        $membresia=Membresia::findOrFail($id);
       	$membresia->tipo=$request->get('tipo');
        $membresia->duracion=$request->get('duracion');
        $membresia->precio=$request->get('precio');
        $membresia->update();
        return Redirect::to('membresia/nueva');
    }
    public function destroy($id)
    {
        $membresia=Membresia::findOrFail($id);
        $membresia->estado='Inactiva';
        $membresia->update();
        return Redirect::to('membresia/nueva');
    }
    public function reporte(){
         //Obtenemos los registros
         $registros=DB::table('rubro')
            ->where ('condicion','=','1')
            ->orderBy('nombre','asc')
            ->get();

         $pdf = new Fpdf();
         $pdf::AddPage();
         $pdf::SetTextColor(35,56,113);
         $pdf::SetFont('Arial','B',11);
         $pdf::Cell(0,10,utf8_decode("Listado Rubros"),0,"","C");
         $pdf::Ln();
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(206, 246, 245); // establece el color del fondo de la celda 
         $pdf::SetFont('Arial','B',10); 
         //El ancho de las columnas debe de sumar promedio 190        
         $pdf::cell(40,8,utf8_decode("Codigo"),1,"","L",true);
         $pdf::cell(50,8,utf8_decode("Nombre"),1,"","L",true);
         $pdf::cell(100,8,utf8_decode("Descripción"),1,"","L",true);
         
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(255, 255, 255); // establece el color del fondo de la celda
         $pdf::SetFont("Arial","",9);
         
         foreach ($registros as $reg)
         {
            $pdf::cell(40,6,utf8_decode($reg->idrubro),1,"","L",true);
            $pdf::cell(50,6,utf8_decode($reg->nombre),1,"","L",true);
            $pdf::cell(100,6,utf8_decode($reg->descripcion),1,"","L",true);
            $pdf::Ln(); 
         }

         $pdf::Output();
         exit;
    }
}

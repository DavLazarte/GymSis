<?php

namespace GymSis\Http\Controllers;

use Illuminate\Http\Request;

use GymSis\Http\Requests;
use GymSis\Socio;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use GymSis\Http\Requests\SocioFormRequest;
use DB;

use Fpdf;

class SocioController extends Controller
{
  
    public function index(Request $request)
    {
        if ($request)
        {
            $query=trim($request->get('searchText'));
            $socios=DB::table('socio')
            ->where('nombre','LIKE','%'.$query.'%')
            ->where('estado','=','Activo')
            ->orwhere('idsocio','LIKE','%'.$query.'%')
            ->where('estado','=','Activo')
             ->orwhere('codigo','LIKE','%'.$query.'%')
            ->where('estado','=','Activo')
            ->orderBy('idsocio','desc')
            ->paginate(7);
            return view('socio.nuevo.index',["socios"=>$socios,"searchText"=>$query]);
        }
    }
    public function create()
    {
        return view("socio.nuevo.create");
    }
    public function store(SocioFormRequest $request)
    {
        $socio=new Socio;
        $socio->nombre=$request->get('nombre');
		$socio->telefono=$request->get('telefono');
        $socio->direccion=$request->get('direccion');
        $socio->codigo=$request->get('codigo');
        $socio->estado='Activo';

        if (Input::hasFile('imagen')){
        	$file=Input::file('imagen');
        	$file->move(public_path().'/imagenes/socios/',$file->getClientOriginalName());
        	$socio->imagen=$file->getClientOriginalName();
        }
        $socio->save();
        return Redirect::to('socio/nuevo');

    }
    public function show($id)
    {
        return view("socio.nuevo.show",["socio"=>Socio::findOrFail($id)]);
    }
    public function edit($id)
    {
        return view("socio.nuevo.edit",["socio"=>Socio::findOrFail($id)]);
    }
    public function update(SocioFormRequest $request,$id)
    {
    	$socio=Socio::findOrFail($id);
        $socio->nombre=$request->get('nombre');
		$socio->telefono=$request->get('telefono');
        $socio->direccion=$request->get('direccion');
        $socio->codigo=$request->get('codigo');
        $socio->estado='Activo';

        if (Input::hasFile('imagen')){
        	$file=Input::file('imagen');
        	$file->move(public_path().'/imagenes/socios/',$file->getSocioOriginalName());
        	$socio->imagen=$file->getSocioOriginalName();
        }
        $socio->update();
        return Redirect::to('socio/nuevo');
    }
    public function destroy($id)
    {
        $socio=Socio::findOrFail($id);
        $socio->estado='Inactivo';
        $socio->update();
        return Redirect::to('socio/nuevo');
    }
    public function reporte(){
         //Obtenemos los registros
         $registros=DB::table('persona')
            ->where ('tipo','=','Cliente')
            ->orderBy('idpersona','desc')
            ->get();

         $pdf = new Fpdf();
         $pdf::AddPage();
         $pdf::SetTextColor(35,56,113);
         $pdf::SetFont('Arial','B',11);
         $pdf::Cell(0,10,utf8_decode("Listado Clientes"),0,"","C");
         $pdf::Ln();
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(206, 246, 245); // establece el color del fondo de la celda 
         $pdf::SetFont('Arial','B',10); 
         //El ancho de las columnas debe de sumar promedio 190   
         $pdf::cell(20,8,utf8_decode("Codigo"),1,"","L",true);     
         $pdf::cell(60,8,utf8_decode("Nombre"),1,"","L",true);
         $pdf::cell(35,8,utf8_decode("Documento"),1,"","L",true);
         $pdf::cell(50,8,utf8_decode("Domicilio"),1,"","L",true);
         $pdf::cell(25,8,utf8_decode("Teléfono"),1,"","L",true);
         
         $pdf::Ln();
         $pdf::SetTextColor(0,0,0);  // Establece el color del texto 
         $pdf::SetFillColor(255, 255, 255); // establece el color del fondo de la celda
         $pdf::SetFont("Arial","",9);
         
         foreach ($registros as $reg)
         {
            $pdf::cell(20,6,utf8_decode($reg->idpersona),1,"","L",true);
            $pdf::cell(60,6,utf8_decode($reg->nombre_apellido),1,"","L",true);
            $pdf::cell(35,6,utf8_decode($reg->dni),1,"","L",true);
            $pdf::cell(50,6,utf8_decode($reg->domicilio),1,"","L",true);
            $pdf::cell(25,6,utf8_decode($reg->telefono),1,"","L",true);
            $pdf::Ln(); 
         }

         $pdf::Output();
         exit;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Localidad;
use App\Departamento;
use App\Visita;
use App\Implementador;
use Carbon\Carbon;
use App\Comentario;
use App\TipoVisita;


class LocalidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request)
       {
           $query=trim($request->get('searchText'));
           $localidades=Localidad::SearchText($query)->get();   
           
            
            return view('localidades.index',["localidades"=>$localidades,"searchText"=>$query]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        if ($request)
        {
            $query=trim($request->get('searchText'));
            if(!empty($query)){
                $localidad=Localidad::FindByNombreLocalidad($query)->first();            
                if(!$localidad){
                    $localidad=new Localidad;
                    $localidad->nombreLocalidad="La localidad $query no existe";
                };
                
            }
            else{
                $localidad=Localidad::FindById($id)->first();
            }
           
            $visitas=Visita::FindByIdLocalidad($localidad->id)->get(); 
            if($visitas->count()==0) {
                $visita=new Visita;                               
                $visita->fecha=Carbon::now();
                $visita->nombreTipoVisita='Sin Visitas';             
                $visitas=collect([$visita]);
            }           
            $comentarios=Comentario::FindByIdLocalidad($localidad->id)->get();
            if($comentarios->count()==0) {
                $comentario=new Comentario;                
                $comentario->comentarios='Sin Comentarios';
                $comentario->fecha_comentario=Carbon::now();
                $comentarios=collect([$comentario]);
            }            
               
            $today=Carbon::now();
            $implementadores=Implementador::get();
            $tipoVisitas=TipoVisita::get();
              
          
           
             
             return view('localidades.show',["tipoVisitas"=>$tipoVisitas, "implementadores"=>$implementadores,"comentarios"=>$comentarios,"localidad"=>$localidad,"visitas"=>$visitas,"searchText"=>$query,'today'=>$today]);
         }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $searchText=$request->get('searchText');
        if($request->get('tipo')){
            $localidad=Localidad::findOrfail($id);
            $localidad->presentacion=$request->get('presentacion');
            $localidad->entrevista=$request->get('entrevista');
            $localidad->informe=$request->get('informe');
            $localidad->save();

            toast("Informacion de visita a Localidad editada con exito!!",'success','top-left');
        }
        else{
            $localidad=Localidad::findOrfail($id);
            
            $localidad->fecha_info=Carbon::createFromFormat('d/m/Y', $request->get('fecha_info'));
            $localidad->ordenanza=$request->get('ordenanza');
            $localidad->veedor=$request->get('veedor');
            $localidad->problema=$request->get('problema');
            $localidad->sin_aplicacion=$request->get('sin_aplicacion');
            $localidad->aplicacion_controlada=$request->get('aplicacion_controlada');
            $localidad->save();
            
        }
        $url="localidades/$id?searchText=$searchText";
    	return Redirect::to($url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function detalleDepartamento(Request $request){
        
        $detalle=Localidad::FiltroDepartamento($request->get('departamento'), $request->get('filtro'))->get();

        return Response::json($detalle); 
        
    }
}

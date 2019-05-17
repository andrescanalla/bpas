<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Localidad;
use App\Departamento;
use App\Visita;
use Carbon\Carbon;
use App\Comentario;


class SettingLocalidadController extends Controller
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
           $localidades=Localidad::FindbyDepartamento($query)->select('localidades.id','localidades.lat', 'localidades.lng', 'localidades.nombre as nombreLocalidad', 'departamentos.nombre as nombreDepartamento')->get();   
           
            
            return view('setting.localidades.index',["localidades"=>$localidades,"searchText"=>$query]);
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
                $localidad=Localidad::FindById($id)->select('localidades.lat','localidades.lng','localidades.id','implementadores.nombre as nombreImplementador','departamentos.nombre as nombreDepartamento', 'localidades.nombre as nombreLocalidad', 'departamentos.id as idDepartamento',  'municipio', 'presentacion','entrevista','informe', 'ordenanza','fecha_info','veedor','problema','sin_aplicacion','aplicacion_controlada')->first();
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
              
          
            
             
             return view('setting.localidades.show',["comentarios"=>$comentarios,"localidad"=>$localidad,"visitas"=>$visitas,"searchText"=>$query,'today'=>$today]);
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
        $localidad=Localidad::FindById($id)->select('localidades.departamento_id','localidades.lat','localidades.lng','localidades.id','implementadores.nombre as nombreImplementador','departamentos.nombre as nombreDepartamento', 'localidades.nombre as nombreLocalidad', 'departamentos.id as idDepartamento',  'municipio', 'presentacion','entrevista','informe', 'ordenanza','fecha_info','veedor','problema','sin_aplicacion','aplicacion_controlada')->first();
        $departamentos=Departamento::get();            
        return view('setting.localidades.edit',["localidad"=>$localidad,"departamentos"=>$departamentos,]);
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
        $localidad=Localidad::findOrfail($id);
        $localidad->lat=$request->get('lat');
        $localidad->lng=$request->get('lng');
        $localidad->departamento_id=$request->get('departamento');
        
        
        $localidad->save();
        $url="setting/localidades";
        
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

    
}

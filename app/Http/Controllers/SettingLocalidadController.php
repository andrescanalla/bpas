<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
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
           $localidades=Localidad::FindbyDepartamento($query)
                ->select('localidades.id','localidades.lat', 'localidades.lng', 'localidades.nombre as nombreLocalidad', 'departamentos.nombre as nombreDepartamento')
                ->orderBY('localidades.id','desc')
                ->get();
            $departamentos=Departamento::get();                   
            
            return view('setting.localidad.index',["localidades"=>$localidades,"searchText"=>$query, "departamentos"=>$departamentos]);
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
        $searchText=trim($request->get('searchText'));
        $nombre=$request->get('nombre');
        $query=Localidad::where('nombre', 'LIKE','%'.$nombre.'%')->first();   
          
        if($query){
            alert()->error('No se pudo crear la Localiad',"$nombre ya existe")->position('top');
        }
        else{
            $localidad=new Localidad;  
            $localidad->nombre=$request->get('nombre');
            $localidad->lat=$request->get('lat');
            $localidad->lng=$request->get('lng');
            $localidad->departamento_id=$request->get('departamento');
            $localidad->save();
            toast('La Localidad se agrego con exito!!','success','bottom-right');

        }
       
        
        $url="setting/localidad?searchText=$searchText";
        
        
        
        return redirect($url); 
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $localidad=Localidad::FindById($id)->select('localidades.departamento_id','localidades.lat','localidades.lng','localidades.id','departamentos.implementador as nombreImplementador','departamentos.nombre as nombreDepartamento', 'localidades.nombre as nombreLocalidad', 'departamentos.id as idDepartamento',  'municipio', 'presentacion','entrevista','informe', 'ordenanza','fecha_info','veedor','problema','sin_aplicacion','aplicacion_controlada')->first();
        $departamentos=Departamento::get();                 
        return view('setting.localidad.edit',["localidad"=>$localidad,"departamentos"=>$departamentos,]);
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
        $localidad->nombre=$request->get('nombre');
        $localidad->departamento_id=$request->get('departamento');        
        
        $localidad->save();
        $url="setting/localidad";
        toast("Localidad editada con exito!!",'success','bottom-right');
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

<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Localidad;
use App\Departamento;
use App\Visita;
use Carbon\Carbon;
use App\Comentario;


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
                $localidad=Localidad::SearchText($query)->first();            
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
                $comentario->fecha_comentario=Carbon::now()->format('d/m/y');
                $comentarios=collect([$comentario]);
            }
               
            $today=Carbon::now();
              
           
          
             
             return view('localidades.show',["comentarios"=>$comentarios,"localidad"=>$localidad,"visitas"=>$visitas,"searchText"=>$query,'today'=>$today]);
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
        //
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

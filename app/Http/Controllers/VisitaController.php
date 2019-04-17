<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Visita;
use App\Implementador;
use App\TipoVisita;
use App\Localidad;


class VisitaController extends Controller
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
           $visitas=Visita::SearchText($query)->paginate(12);
           $implementadores=Implementador::get();
           $tipoVisitas=TipoVisita::get();
           
            
            return view('visitas.index',["visitas"=>$visitas,"tipoVisitas"=>$tipoVisitas,"implementadores"=>$implementadores,"searchText"=>$query]);
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
    public function show($id)
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
        $visita=Visita::findOrFail($id);
        $page=$request->get('page');
        $searchText=$request->get('searchText');
    	$visita->fecha=$request->get('fecha');
        $visita->implementador_id=$request->get('implementador_id');
        $visita->tipo_visita_id=$request->get('tipo_visita_id');
        $queryLocalidad=Localidad::FindByNombreLikeId($request->get('localidad'))->first();        
        if($queryLocalidad){
            $visita->localidad_id=$queryLocalidad->id;            
        }
        else{
            $localidad=new Localidad;
            $localidad->nombre = $request->get('localidad');
            $localidad->departamento_id = Implementador::findOrFail($visita->implementador_id)->departamento_id;           
            $localidad->save();
            $visita->localidad_id = $localidad->id;
        }         
        $visita->comentarios=$request->get('comentarios');       
        $visita->save();
        $url="visitas?searchText=$searchText&page=$page";
        
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

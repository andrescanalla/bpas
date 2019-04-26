<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Departamento;
use App\Comentario;
use Carbon\Carbon;

class ComentarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $localidad_id=$request->get('id');
        $comentario=new Comentario;
        $searchText=$request->get('searchText');
        $comentario->fecha_comentario=Carbon::createFromFormat('d/m/Y', $request->get('fecha_comentario'));
        $comentario->comentarios=$request->get('comentarios');
        $comentario->localidad_id=$localidad_id;
        $comentario->save();
        $url="localidades/$localidad_id?searchText=$searchText";
        
    	return Redirect::to($url);
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
        
        $comentario=Comentario::findOrfail($id);
        $searchText=$request->get('searchText');
        $localidad_id=$request->get('id');
        $comentario->fecha_comentario=Carbon::createFromFormat('d/m/Y', $request->get('fecha_comentario'));
        $comentario->comentarios=$request->get('comentarios');
        $comentario->localidad_id=$localidad_id;
        $comentario->save();
        $url="localidades/$localidad_id?searchText=$searchText";
        return Redirect::to($url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $comentario=Comentario::findOrfail($id);
        $searchText=$request->get('searchText');
        $localidad_id=$request->get('id');
        $comentario->delete();
        $url="localidades/$localidad_id?searchText=$searchText";
        return Redirect::to($url);
    }
}

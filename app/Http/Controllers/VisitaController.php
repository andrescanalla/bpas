<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Visita;
use App\Implementador;
use App\TipoVisita;
use App\Localidad;
use Spatie\GoogleCalendar\Event;
use App\Comentario;
use Carbon\Carbon;



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
           $visitas=Visita::SearchText($query)->paginate(10);
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
    	$visita->fecha=Carbon::createFromFormat('d/m/Y', $request->get('fecha'));;
        $visita->implementador_id=$request->get('implementador_id');
        $visita->tipo_visita_id=$request->get('tipo_visita_id');
        $queryLocalidad=Localidad::FindByNombreLikeId($request->get('localidad'))->first();  

        if($request->get('tipo')){
            $departamento_id=$request->get('tipo');
            $url="departamentos/$departamento_id";
        }
        elseif($request->get('localidadShow')){
            $localidad_id=$request->get('localidadShow');
            $url="localidades/$localidad_id";
        }
        else{
            $url="visitas?searchText=$searchText&page=$page";
        }
        
        if($queryLocalidad){
            $visita->localidad_id=$queryLocalidad->id; 
            if($visita->tipo_visita_id==1){
                $queryLocalidad->presentacion=1;                
                $queryLocalidad->save();
                      
            }
            if($visita->tipo_visita_id==2){
                // $queryLocalidad->presentacion=1;
                $queryLocalidad->entrevista=1;               
                $queryLocalidad->save();
                
            }
            if($visita->tipo_visita_id==3){
                $queryLocalidad->presentacion=1;
                $queryLocalidad->entrevista=1;               
                $queryLocalidad->save();
                
            } 
            // if($visita->tipo_visita_id==2||$visita->tipo_visita_id==3){
            //    $queryLocalidad->presentacion=1;
            //    $queryLocalidad->entrevista=1;               
            //    $queryLocalidad->save();                
            // } 
            if($visita->tipo_visita_id==4){
                // $queryLocalidad->presentacion=1;
                // $queryLocalidad->entrevista=1;
                $queryLocalidad->informe=1;
                $queryLocalidad->save();
            }              
        }
        else{
            // definir como hacer: 
            /**opcion 1: toast con error no exite esa localida. debe crearla en setting. */
                $localidad=$request->get('localidad');
                alert()->error("La Localidad $localidad no existe",'Si lo desea puede agregarla en Setting->Localidades');
                return Redirect::to($url);           
            /** opcion 2: crear nueva localidad.- Mmmmm
             * $localidad=new Localidad;
             * $localidad->nombre = $request->get('localidad');
             * $localidad->departamento_id = Implementador::findOrFail($visita->implementador_id)->departamento_id;           
             * $localidad->save();
             * $visita->localidad_id = $localidad->id;
            */
        }         
        $visita->comentarios=$request->get('comentarios');       
        $visita->save();
        
        
        toast('Visita editada con exito!!','success','top-left');
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
       

        $visita=Visita::findOrFail($id);
         /*eliminar del calendar */
         $event = Event::find($visita->calendar_id);         
         $event->delete();
         /*****/
        $page=$request->get('page');
        $searchText=$request->get('searchText');
        $comentarios=Comentario::where('localidad_id',$visita->localidad_id)->get();
        if($comentarios){
            foreach ($comentarios as $comentario){
                $comentario->delete();
            }
        }
        if ($visita->tipo_visita_id==1){
            $localidad=Localidad::findOrFail($visita->localidad_id);
            $localidad->presentacion=0;
            $localidad->save();
        }
        if ($visita->tipo_visita_id==2){
            $localidad=Localidad::findOrFail($visita->localidad_id);
            $localidad->entrevista=0;
            $localidad->save();
        }
        if ($visita->tipo_visita_id==3){
            $localidad=Localidad::findOrFail($visita->localidad_id);
            $localidad->presentacion=0;
            $localidad->entrevista=0;
            $localidad->save();
        }
        if ($visita->tipo_visita_id==4){
            $localidad=Localidad::findOrFail($visita->localidad_id);
            $localidad->informe=0;
            $localidad->save();
        }        
        $visita->delete();
        

        $url="visitas?searchText=$searchText&page=$page";
        return Redirect::to($url);

    }
}

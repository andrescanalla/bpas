<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use App\Http\Requests;
use Carbon\Carbon;
use Spatie\GoogleCalendar\Event;
use DB;
use App\Dashboard;
use App\Implementador;
use App\Visita;
use App\Localidad;
use App\TipoVisita;



class DashboardController extends Controller
{
   public function index(Request $request)
   {
     $presentacion=Localidad::CountTotal('presentacion')->count();
     $belgrano=Localidad::CountDepartamento('Belgrano','presentacion')->count();
     $constitucion=Localidad::CountDepartamento('Constitucion','presentacion')->count();
     $lopez=Localidad::CountDepartamento('General Lopez','presentacion')->count();
     $rosario=Localidad::CountDepartamento('Rosario','presentacion')->count();
     $san=Localidad::CountDepartamento('San Lorenzo','presentacion')->count();
     $iriondo=Localidad::CountDepartamento('Iriondo','presentacion')->count();
     $caseros=Localidad::CountDepartamento('Caseros','presentacion')->count();
    
     $chartjs1 = app()->chartjs
        ->name('lineChartTest')
        ->type('line')
        ->size(['width' => 400, 'height' => 266])
        ->labels(Dashboard::mesLabel())
        ->datasets([            
            [
                "label" => "Presentacion",
                'backgroundColor' => 'rgba(255, 206, 86, 0.2)',
                'borderColor' => "rgba(255, 206, 86, 0.2)",
                "pointBorderColor" => "rgba(255, 206, 86, 0.2)",
                "pointBackgroundColor" => "rgba(255, 206, 86, 0.2)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => Dashboard::CountTipoVisitaTotal('presentacion programa'),
            ],
            [
                "label" => "Entrevista.",     
                'backgroundColor' => 'rgba(255, 206, 86, 0.5)',
                'borderColor' => "rgba(255, 206, 86, 0.5)",
                "pointBorderColor" => "rgba(255, 206, 86, 0.5)",
                "pointBackgroundColor" => "rgba(255, 206, 86, 0.5)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",           
                'data' => Dashboard::CountTipoVisitaTotal('entrevista'),
            ],
            [
                "label" => "Informe", 
                'backgroundColor' => 'rgba(255, 206, 86, 0.8)',
                'borderColor' => "rgba(255, 206, 86, 0.8)",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",               
                'data' => Dashboard::CountTipoVisitaTotal('informe'),
            ]            
        ])
        ->options(["title"=>["display"=>true,"text"=>"Acumulado"],"legend"=>["position"=>"bottom"]]);       

     $chartjs2 = app()->chartjs
         ->name('barChartTest')
         ->type('bar')
         ->size(['width' => 400, 'height' => 286])
         ->labels(Dashboard::mesLabel())
         ->datasets([  
            [
                "label" => "Pres.",
                'backgroundColor' => 'rgba(255, 206, 86, 0.2)',                 
                'data' => Dashboard::CountTipoVisita('presentacion programa'),
                'borderColor'=> 'rgba(255, 206, 86, 1)',
                'borderWidth'=> 1
            ], 
            [
                "label" => "Entrev.",
                'backgroundColor' => 'rgba(255, 206, 86, 0.5)',
                'data' => Dashboard::CountTipoVisita('entrevista'),
                'borderColor'=> 'rgba(255, 206, 86, 1)',
                'borderWidth'=> 1

             ],
             [
                "label" => "Inf.",
                'backgroundColor' =>"rgba(255, 206, 86, 0.8)",
                'data' => Dashboard::CountTipoVisita('informe'),
                'borderColor'=> 'rgba(255, 206, 86, 1)',
                'borderWidth'=> 1

             ],        
             [
                 "label" => "Otro",
                 'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                 'data' => Dashboard::CountTipoVisita('otro'),
                 'borderColor'=> 'rgba(255, 206, 86, 1)',
                 'borderWidth'=> 1

             ]             
             
         ])
         ->options(["title"=>["display"=>true,"text"=>"Mensual"],"legend"=>["position"=>"bottom"]]);

     
     $today=Carbon::now();    
     $todo=Visita::Todo( Carbon::now()->subDays(15), Carbon::now()->addDays(15) )->get();
     
     return view("dashboard.index", compact('chartjs1','chartjs2'), [
        "presentacion"=>$presentacion, 
        'belgrano'=>$belgrano,
        'constitucion'=>$constitucion,
        'lopez'=>$lopez,
        'rosario'=>$rosario,
        'san'=>$san,
        'caseros'=>$caseros,
        'iriondo'=>$iriondo,
        'todo'=>$todo,
        'today'=>$today
    ]);
    
    }

    public function importEvent()
    {  
        $start=new Carbon('01-10-2018');        
        $end=new Carbon('13-04-2019');
        $events=Event::get($start, $end);
        $count=0;
        foreach ($events as $event) {
            $queryEvent=Visita::FindByCalendarId($event->id)->first();
            if(!$queryEvent){
                          
                $visita=new Visita;
                $visita->calendar_id= $event->id;  
                $calendarSummary=explode('-',trim($event->summary));                
                $calendarImplementadorSummary=trim($calendarSummary[0]);
                if(count($calendarSummary)>1){
                    $calendarTipoSummary=trim($calendarSummary[1]);
                }
                else{
                    $calendarTipoSummary='nada';             
                }                
                if(count($calendarSummary)>2){
                $calendarLocalidadSummary=trim($calendarSummary[2]);
                }
                else{
                    $calendarLocalidadSummary='nada';
                }                
                $queryImplementador=Implementador::FindByNombre($calendarImplementadorSummary)->first();
                
                
                if($queryImplementador){
                    $visita->implementador_id=$queryImplementador->id;
                    $queryLocalidadSummary=Localidad::FindByNombre($calendarLocalidadSummary)->first();
                    if(!$queryLocalidadSummary && !$event->location){                        
                        $localidad=new Localidad;
                        $localidad->departamento_id=$queryImplementador->departamento_id;
                        $localidad->nombre=$calendarLocalidadSummary;
                        $localidad->save();
                        $visita->localidad_id=$localidad->id;
                    }
                    if(!$queryLocalidadSummary && $event->location){  
                        $calendarLocalidad=explode(',' , $event->location)[0];                          
                        $queryLocalidad=Localidad::FindByNombre($calendarLocalidad)->first();
                        if(!$queryLocalidad){
                            $localidad=new Localidad;
                            $localidad->departamento_id=$queryImplementador->departamento_id;
                            $localidad->nombre=$calendarLocalidad;
                            $localidad->save();
                            $visita->localidad_id=$localidad->id;
                        }                    
                        else{
                        $visita->localidad_id=$queryLocalidad->id;
                        }
                    }
                    if($queryLocalidadSummary){
                        $visita->localidad_id=$queryLocalidadSummary->id;
                    }

                }
                else{
                    $visita->implementador_id=1; 
                    $visita->localidad_id=1;                             
                }
                $visita->fecha=$event->start->date;
                $visita->comentarios = $event->summary;    
                $queryTipoVisita=TipoVisita::FindByNombre($calendarTipoSummary)->first();                
                if(!$queryTipoVisita) {
                    $visita->tipo_visita_id=5;
                }
                else{
                    $visita->tipo_visita_id=$queryTipoVisita->id;
                }               
                                                      
                $visita->save();
                $count=++$count;
                
                
            }


        }
       
        return Response::json($count);
    }

    public function settingLocalidades(){
        $visitas= Visita::get();
        $count=0;
        foreach ($visitas as $visita) {
           if($visita->localidad_id!==1){
             if($visita->tipo_visita_id==1){
                $localidad=Localidad::findOrFail($visita->localidad_id);
                $localidad->presentacion=true;
                $localidad->save();
                
             }
             if($visita->tipo_visita_id==2){
                $localidad=Localidad::findOrFail($visita->localidad_id);
                $localidad->entrevista=true;
                $localidad->save();
               
             }
             if($visita->tipo_visita_id==3){
                $localidad=Localidad::findOrFail($visita->localidad_id);
                $localidad->entrevista=true;
                $localidad->presentacion=true;
                $localidad->save();
               
             }
             if($visita->tipo_visita_id==4){
                $localidad=Localidad::findOrFail($visita->localidad_id);
                $localidad->informe=true;
                $localidad->save();
                
             }  
            # dd($visita , $visita->localidad_id);
            $count=++$count;
           }
           
        }
        return Response::json($count);
        

    }

    public function todo(Request $request)
    {   
       
         if($request->get('tipo')==1){
            $f=Carbon::now();
            $todo=new Dash;
            $todo->comment=$request->get('comentarios');
            $todo->todo=$request->get('todo');
            $todo->fecha=$f->format('Y-m-d');   
            
            $todo->save(); 
            return Redirect::back();   
        }
        if($request->get('tipo')==2){
            $todo=Dash::findOrFail($request->get('id')); 
            $todo->comment=$request->get('comentarios');
            $todo->todo=$request->get('todo');
            $todo->checkk=$request->get('check');    
            $todo->update(); 
            return Redirect::back();   
        }
        if($request->get('tipo')==3){
            $todo=Dash::findOrFail($request->get('iddash'));                       
            $todo->delete();
             $response = [
                'msg' => 'Pedido Eliminado',
            ];
            if($request->ajax()) { 
                return Response::json($todo);
            }
            else{
                return Redirect::back();    
            }
            
        }
        if($request->get('tipo')==4){
          if($request->ajax()) {
            $f=Carbon::now();
            $todo=new Dash;
            if (!empty($request->get('comentarios'))){
            $todo->comment=$request->get('comentarios');
            }
            $todo->todo=$request->get('todo');
            $todo->usuario=$request->get('usuario');
            $todo->fecha=$f->format('Y-m-d');  
            $todo->tipo='p';        
            $todo->save(); 
            $response = [
                'msg' => 'Pedido guardado',
            ];
            
            return Response::json($todo);

           }
        return Redirect::back();   
        }
        if($request->get('tipo')==5){
        $todo=Dash::findOrFail($request->get('id')); 
        $todo->comment=$request->get('comentarios');
        $todo->todo=$request->get('todo');
        $todo->checkk=$request->get('check'); 
        $todo->usuario=$request->get('usuario');   
        $todo->update(); 
        return Redirect::back();        
                   
        }
        if($request->get('tipo')==6){
          if($request->ajax()) {
            $f=Carbon::now();
            $todo=new Dash;
            if (!empty($request->get('comentarios'))){
            $todo->comment=$request->get('comentarios');
            }            
            $todo->usuario=$request->get('usuario');
            $todo->fecha=$f->format('Y-m-d'); 
            $todo->tel=$request->get('tel');
            $todo->tipo='a';        
            $todo->save(); 
            $response = [
                'msg' => 'Pedido guardado',
            ];
            
            return Response::json($todo);

           }
        return Redirect::back();   
        }
        if($request->get('tipo')==7){
        $todo=Dash::findOrFail($request->get('id')); 
        $todo->comment=$request->get('comentarios');
        $todo->todo='1';
        $todo->tel=$request->get('tel');
        $todo->usuario=$request->get('usuario');   
        $todo->update(); 
        return Redirect::back();        
                   
        }
        
    }
    public function cale(Request $request){
        if ($request->get('type')==null){
            $cale=DB::table('dash')
                ->where('end','!=',null)
                ->where('todo','=',2)
                ->select('start', 'end','comment as title','iddash as id')
                ->get(); 
             return Response::json($cale);
        }
        else {
            $type = $request->get('type');
                if($type == 'new')
                    {
                        $event= new Dash;
                        $event->comment=$request->get('title');
                        $event->start = Carbon::now();
                        $event->fecha = Carbon::now();
                        $event->end = Carbon::now()->addHour();
                        $event->todo =2;
                        $event->save();                                              
                        echo json_encode(array('status'=>'success'));               
                    }
                if($type == 'resetdate')
                    {
                        $startdate = new Carbon($request->get('start'));               
                        $enddate = new Carbon($request->get('end'));
                        $eventid = $request->get('eventid');     
                       
                        $event = Dash::find($eventid);
                        $event->start = $startdate;
                        $event->fecha = $startdate;
                        $event->end = $enddate;
                        $event->save();                
                    }
                if($type == 'changetitle')
                    {
                        $eventid = $request->get('eventid');
                        $eventtitle = $request->get('title');     
                       
                        $event = Dash::find($eventid);
                        $event->comment = $eventtitle;                
                        $event->save();
                        echo json_encode(array('status'=>'success'));                
                    }
                if($type == 'remove')
                    {
                        $eventid = $request->get('eventid');
                        $event = Dash::find($eventid);
                        $event->delete();
                        
                        if($event)
                            echo json_encode(array('status'=>'success'));
                        else
                            echo json_encode(array('status'=>'failed'));
                    }    
        }
    }
    public function calr(Request $request){
        if ($request->get('type')==null){
              $calr=DB::table('dash')
                ->where('end','!=',null)
                ->where('todo','=',3)
                ->select('start', 'end','comment as title','iddash as id')
                ->get(); 
            return Response::json($calr); 
        }
        else {
            $type = $request->get('type');
                if($type == 'new')
                    {
                        $event= new Dash;
                        $event->comment=$request->get('title');
                        $event->start = Carbon::now();
                        $event->fecha = Carbon::now();
                        $event->end = Carbon::now()->addHour();
                        $event->todo =3;
                        $event->save();
                                              
                        echo json_encode(array('status'=>'success'));               
                    }
                if($type == 'resetdate')
                    {
                        $startdate = new Carbon($request->get('start'));               
                        $enddate = new Carbon($request->get('end'));
                        $eventid = $request->get('eventid');     
                       
                        $event = Dash::find($eventid);
                        $event->start = $startdate;
                        $event->fecha = $startdate;
                        $event->end = $enddate;
                        $event->save();                
                    }    
        }
    }
     public function calc(Request $request){
        if ($request->get('type')==null){
              $calc=DB::table('dash')
                ->where('end','!=',null)
                ->where('todo','=',4)
                ->select('start', 'end','comment as title','iddash as id')
                ->get(); 
            return Response::json($calc); 
        }
        else {
            $type = $request->get('type');
                if($type == 'new')
                    {
                        $event= new Dash;
                        $event->comment=$request->get('title');
                        $event->start = Carbon::now();
                        $event->fecha = Carbon::now();
                        $event->end = Carbon::now()->addHour();
                        $event->todo =4;
                        $event->save();
                                              
                        echo json_encode(array('status'=>'success'));               
                    }
                 
        }
    }
    
}

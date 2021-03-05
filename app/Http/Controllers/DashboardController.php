<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use Carbon\Carbon;
use Spatie\GoogleCalendar\Event;
use DB;
use App\Dashboard;
use App\Implementador;
use App\Visita;
use App\Localidad;
use App\TipoVisita;
use App\Comentario;





class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $this->credentials();
        //$actualizacion=$this->importEvent(Carbon::now()->subDays(20), Carbon::now()->addDays(20));
        $presentacion = Localidad::CountTotal('presentacion')->count();
        $belgrano = Localidad::CountDepartamento('Belgrano', 'presentacion')->count();
        $constitucion = Localidad::CountDepartamento('Constitucion', 'presentacion')->count();
        $lopez = Localidad::CountDepartamento('General Lopez', 'presentacion')->count();
        $rosario = Localidad::CountDepartamento('Rosario', 'presentacion')->count();
        $san = Localidad::CountDepartamento('San Lorenzo', 'presentacion')->count();
        $iriondo = Localidad::CountDepartamento('Iriondo', 'presentacion')->count();
        $caseros = Localidad::CountDepartamento('Caseros', 'presentacion')->count();

        $chartjs1 = app()->chartjs
            ->name('lineChartTest')
            ->type('line')
            ->size(['width' => 400, 'height' => 266])
            ->labels(Dashboard::mesLabel())
            ->datasets([
                [
                    "label" => "Informes",
                    'backgroundColor' => '#d9edf7d1',
                    'borderColor' => "#31708f",
                    "pointBorderColor" => "#31708f",
                    "pointBackgroundColor" => "#d9edf7",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => Dashboard::CountTipoVisitaTotal('informe'),
                ],

                [
                    "label" => "Entrevistas",
                    'backgroundColor' => 'rgba(255, 206, 86, 0.5)',
                    'borderColor' => "rgba(255, 206, 86, 1)",
                    "pointBorderColor" => "rgba(255, 206, 86, 1)",
                    "pointBackgroundColor" => "#fcf8e3",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => Dashboard::CountTipoVisitaTotal('entrevista'),
                ],

                [
                    "label" => "Presentaciones",
                    'backgroundColor' => '#dff0d8',
                    'borderColor' => "#2e8631",
                    "pointBorderColor" => "#2e8631",
                    "pointBackgroundColor" => "#dff0d8",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => Dashboard::CountTipoVisitaTotal('presentacion programa'),
                ],
            ])
            ->options(["title" => ["display" => false, "text" => "Acumulado"], "legend" => ["position" => "bottom"]]);

        $chartjs2 = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 400, 'height' => 286])
            ->labels(Dashboard::mesLabel())
            ->datasets([
                [
                    "label" => "Pres.",
                    'backgroundColor' => '#2dc37f',
                    'data' => Dashboard::CountTipoVisita('presentacion programa'),
                    'borderColor' => '#656565',
                    'borderWidth' => 1
                ],
                [
                    "label" => "Entrev.",
                    'backgroundColor' => '#ffc66a',
                    'data' => Dashboard::CountTipoVisita('entrevista'),
                    'borderColor' => '#656565',
                    'borderWidth' => 1

                ],
                [
                    "label" => "Inf.",
                    'backgroundColor' => "#7ee6ff",
                    'data' => Dashboard::CountTipoVisita('informe'),
                    'borderColor' => '#656565',
                    'borderWidth' => 1

                ],
                [
                    "label" => "Otro",
                    'backgroundColor' => "#ccc",
                    'data' => Dashboard::CountTipoVisita('otro'),
                    'borderColor' => '#656565',
                    'borderWidth' => 1

                ]

            ])
            ->optionsRaw("{
                scales: {
                    xAxes: [{
                        stacked: true
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                },
                legend: { position: 'bottom' },
                title: { display: false, text: 'Mensual' }
                
            }");


        $today = Carbon::now();
        $todo = Visita::Todo(20, 20)->get();



        return view("dashboard.index", compact('chartjs1', 'chartjs2'), [
            "presentacion" => $presentacion,
            'belgrano' => $belgrano,
            'constitucion' => $constitucion,
            'lopez' => $lopez,
            'rosario' => $rosario,
            'san' => $san,
            'caseros' => $caseros,
            'iriondo' => $iriondo,
            'todo' => $todo,
            'searchText' => '',
            'today' => $today
        ]);
    }
    public function setLocalidad($fecha, $tipo_visita_id, $localidad)
    {
        $n = 0;
        if (Carbon::now() > $fecha) {
            if ($tipo_visita_id == 1) {
                $localidad->presentacion = 1;
            }
            if ($tipo_visita_id == 2 || $tipo_visita_id == 3) {
                $localidad->presentacion = 1;
                $localidad->entrevista = 1;
            }
            if ($tipo_visita_id == 4) {
                $localidad->presentacion = 1;
                $localidad->entrevista = 1;
                $localidad->informe = 1;
            }
            $n = ++$n;
        }
        $localidad->save();
        return $n;
    }
    public function importEvent($desde, $hasta)
    {
        $start = new Carbon($desde);
        $end = new Carbon($hasta);
        $events = Event::get($start, $end, ['showDeleted' => true]);
        /***contadores*** */
        $err = 0;
        $set = 0; //cantidad de localidades que se actualizaron las visitas
        $unset = 0; // cantidad de visitas sin cambios
        $del = 0; //catidad de visitas eliminadas
        $ac = 0;  //catidad de visitas actualizadas
        $new = 0; //catidad de visitas creadas
        $count = $del + $ac + $new + $set; //total de visitas revisadas para actualizacion      

        foreach ($events as $event) {
            /***Evento de eliminado***=>Busca si el vento fue borrado del Calender y lo elimina en la BD  */
            if ($event->status == "cancelled") {

                $visita = Visita::where('calendar_id', $event->id)->first();
                if ($visita) {
                    $comentarios = Comentario::where('localidad_id', $visita->localidad_id)->get();
                    //borra los comentarios relacionados con el evento y los elimina
                    if ($comentarios) {
                        foreach ($comentarios as $comentario) {
                            $comentario->delete();
                        }
                    }
                    /***Busca la localidad del evento y pone en 0 el tipo de visita realizada */
                    if ($visita->tipo_visita_id == 1) {
                        $localidad = Localidad::findOrFail($visita->localidad_id);
                        $localidad->presentacion = 0;
                        $localidad->save();
                    }
                    if ($visita->tipo_visita_id == 2) {
                        $localidad = Localidad::findOrFail($visita->localidad_id);
                        $localidad->entrevista = 0;
                        $localidad->save();
                    }
                    if ($visita->tipo_visita_id == 3) {
                        $localidad = Localidad::findOrFail($visita->localidad_id);
                        $localidad->presentacion = 0;
                        $localidad->entrevista = 0;
                        $localidad->save();
                    }
                    if ($visita->tipo_visita_id == 4) {
                        $localidad = Localidad::findOrFail($visita->localidad_id);
                        $localidad->informe = 0;
                        $localidad->save();
                    }
                    $visita->delete();
                    $del = ++$del;
                }
            }
            /***Evento***=>El evento no tiene status de  eliminado */
            else {
                $queryEvent = Visita::FindByCalendarId($event->id)->first();   // busca la visita en la BD         
                $eventUpdate = new Carbon($event->updated);
                $eventUpdate = $eventUpdate->toDateTimeString(); // fecha de update del evento
                $queryUpdate = Visita::FindByCalendarId($event->id)->where('calendar_update', $eventUpdate)->first(); // busca si el evento no fue actualizdo => devuelve null si fue actualizado

                /******* */
                $calendarSummary = explode('-', trim($event->summary));
                $calendarImplementadorSummary = trim($calendarSummary[0]);
                if (count($calendarSummary) > 1) {
                    $calendarTipoSummary = trim($calendarSummary[1]);
                } else {
                    $calendarTipoSummary = 'nada';
                }
                if (count($calendarSummary) > 2) {
                    //$calendarLocalidadSummary=trim($calendarSummary[2]);
                    $calendarComentarioSummary = trim($calendarSummary[2]);
                } else {
                    // $calendarLocalidadSummary='nada';
                    $calendarComentarioSummary = null;
                }

                /****** */

                /***no Existe la visita***=>Crea una visita en BD*/
                if (!$queryEvent) {
                    $visita = new Visita;
                    $visita->calendar_id = $event->id;
                    $new = ++$new;
                }
                // ***Existe la visita***
                else {
                    /***Evento actualizado***=>Busca si el evento esta actulizado */
                    if (!$queryUpdate) {
                        $visita = $queryEvent;    // busca la visita en bd                 
                        $ac = ++$ac;
                    } else {

                        $visita = $queryEvent;    // busca la visita en bd  
                        if ($visita->fecha > Carbon::now()->subDays(5)) {

                            $calendarLocalidad = explode(',', $event->location)[0];
                            $queryLocalidad = Localidad::FindByNombre($calendarLocalidad)->first();
                            $set = $set + $this->setLocalidad($visita->fecha, $visita->tipo_visita_id, $queryLocalidad);
                            //dd('evento SIN modificar del Calendar, visitas en localidades ACTUALIZADAS', $unset , $set);
                        }
                        $unset = ++$unset;
                        //dd('evento SIN modificar del Calendar', $event, $unset);
                    }
                }

                if (!$queryUpdate || !$queryEvent) {
                    $visita->fecha = $event->start->date; //actuliza fecha
                    $visita->comentarios = $this->setComentarios($calendarComentarioSummary, $event->description); //actualiza comentarios
                    $visita->calendar_update = $eventUpdate;  //actualiza update 
                    $queryTipoVisita = TipoVisita::FindByNombre($calendarTipoSummary)->first();
                    if (!$queryTipoVisita) {
                        $visita->tipo_visita_id = 5;
                    } else {
                        $visita->tipo_visita_id = $queryTipoVisita->id;
                    }

                    $queryImplementador = Implementador::FindByNombre($calendarImplementadorSummary)->first();
                    /*Existe el Implementador */
                    if ($queryImplementador && $queryImplementador->nombre != 'Equipo') {

                        $visita->implementador_id = $queryImplementador->id;
                        //$queryLocalidadSummary=Localidad::FindByNombre($calendarLocalidadSummary)->first();  
                        $calendarLocalidad = explode(',', $event->location)[0];
                        $queryLocalidad = Localidad::FindByNombre($calendarLocalidad)->first();

                        /* Existe Localidad en el evento */
                        if ($calendarLocalidad) {
                            /* No Existe resultado de Localidad en la busqueda de la BD */
                            if (!$queryLocalidad) {
                                //$localidad=new Localidad;                      
                                //$localidad->departamento_id=$queryImplementador->departamento_id;
                                //$localidad->nombre=$calendarLocalidadSummary;
                                //$set= $set + $this->setLocalidad( $visita->fecha, $visita->tipo_visita_id, $localidad);
                                //$visita->localidad_id=$localidad->id;  
                                $err = ++$err;
                                $fecha = $visita->fecha->format('d/m/y');

                                alert()->error("Error de Sinc  - Visita del $fecha, Localidad $event->location inexistente", "La localidad no se encuentra creada en el sistema. - Error:$err");
                            }
                            /* Existe resultado de  Localidad en la BD*/ else {

                                $visita->localidad_id = $queryLocalidad->id;
                                $set = $set + $this->setLocalidad($visita->fecha, $visita->tipo_visita_id, $queryLocalidad);
                                $visita->save();
                            }
                        }
                        /* No Existe Localidad en el evento */ else {
                            $queryLocalidadDpto = Localidad::where('departamento_id', $queryImplementador->departamento_id)->where('nombre', 'LIKE', '%' . 'Dpto' . '%')->first();
                            $visita->localidad_id = $queryLocalidadDpto->id;
                            $visita->save();
                        }
                    }
                    /*No Existe el Implementador (es una visita de todo el equipo) */ else {

                        $visita->implementador_id = 1;
                        $visita->localidad_id = 1;
                        $visita->tipo_visita_id = 5;
                        //dd('evento Modificado del Calendar; No existe implementador', $visita);
                        $visita->save();
                    }
                }
            }
        }
        if ($err == 0) {
            alert()->success("          
            <div>
            <h4 style='color:#48964a;margin-bottom: 0;'>Sync Google Calender Exitosa!!</h4>
            <ul style='list-style-type:none;text-align: left;'>           
            <li>$ac Visitas Actualizadas</li>
            <li>$new Visitas Creadas</li>            
            <li>$del Visitas Eliminadas</li>            
          </ul></div>")->toHtml()->toToast('top-left');
        }
        return Response::json(['new' => $new, 'cant' => $count, 'set' => $set, 'ac' => $ac, 'unset' => $unset, 'del' => $del]);
    }

    public function settingLocalidades()
    {
        $visitas = Visita::get();
        $count = 0;
        foreach ($visitas as $visita) {
            if ($visita->localidad_id !== 1) {
                if ($visita->tipo_visita_id == 1) {
                    $localidad = Localidad::findOrFail($visita->localidad_id);
                    $localidad->presentacion = true;
                    $localidad->save();
                }
                if ($visita->tipo_visita_id == 2) {
                    $localidad = Localidad::findOrFail($visita->localidad_id);
                    $localidad->entrevista = true;
                    $localidad->save();
                }
                if ($visita->tipo_visita_id == 3) {
                    $localidad = Localidad::findOrFail($visita->localidad_id);
                    $localidad->entrevista = true;
                    $localidad->presentacion = true;
                    $localidad->save();
                }
                if ($visita->tipo_visita_id == 4) {
                    $localidad = Localidad::findOrFail($visita->localidad_id);
                    $localidad->informe = true;
                    $localidad->save();
                }
                # dd($visita , $visita->localidad_id);
                $count = ++$count;
            }
        }
        return Response::json($count);
    }
    public function credentials()
    {
        $cred =  getenv('GOOGLE_CALENDAR_SAC');
        if ($cred !== false && Storage::exists('service-account-credentials.json') == false) {
            Storage::put('service-account-credentials.json', $cred);
        }
    }
    public function setComentarios($comentario1, $comentario2)
    {
        $comentario = null;
        if ($comentario1 && $comentario2) {
            $comentario = "$comentario1 - $comentario2";
        }
        if ($comentario1 && !$comentario2) {
            $comentario = $comentario1;
        }
        if (!$comentario1 && $comentario2) {
            $comentario = $comentario2;
        }
        return $comentario;
    }

    public function todo(Request $request)
    {

        if ($request->get('tipo') == 1) {
            $f = Carbon::now();
            $todo = new Dash;
            $todo->comment = $request->get('comentarios');
            $todo->todo = $request->get('todo');
            $todo->fecha = $f->format('Y-m-d');

            $todo->save();
            return Redirect::back();
        }
        if ($request->get('tipo') == 2) {
            $todo = Dash::findOrFail($request->get('id'));
            $todo->comment = $request->get('comentarios');
            $todo->todo = $request->get('todo');
            $todo->checkk = $request->get('check');
            $todo->update();
            return Redirect::back();
        }
        if ($request->get('tipo') == 3) {
            $todo = Dash::findOrFail($request->get('iddash'));
            $todo->delete();
            $response = [
                'msg' => 'Pedido Eliminado',
            ];
            if ($request->ajax()) {
                return Response::json($todo);
            } else {
                return Redirect::back();
            }
        }
        if ($request->get('tipo') == 4) {
            if ($request->ajax()) {
                $f = Carbon::now();
                $todo = new Dash;
                if (!empty($request->get('comentarios'))) {
                    $todo->comment = $request->get('comentarios');
                }
                $todo->todo = $request->get('todo');
                $todo->usuario = $request->get('usuario');
                $todo->fecha = $f->format('Y-m-d');
                $todo->tipo = 'p';
                $todo->save();
                $response = [
                    'msg' => 'Pedido guardado',
                ];

                return Response::json($todo);
            }
            return Redirect::back();
        }
        if ($request->get('tipo') == 5) {
            $todo = Dash::findOrFail($request->get('id'));
            $todo->comment = $request->get('comentarios');
            $todo->todo = $request->get('todo');
            $todo->checkk = $request->get('check');
            $todo->usuario = $request->get('usuario');
            $todo->update();
            return Redirect::back();
        }
        if ($request->get('tipo') == 6) {
            if ($request->ajax()) {
                $f = Carbon::now();
                $todo = new Dash;
                if (!empty($request->get('comentarios'))) {
                    $todo->comment = $request->get('comentarios');
                }
                $todo->usuario = $request->get('usuario');
                $todo->fecha = $f->format('Y-m-d');
                $todo->tel = $request->get('tel');
                $todo->tipo = 'a';
                $todo->save();
                $response = [
                    'msg' => 'Pedido guardado',
                ];

                return Response::json($todo);
            }
            return Redirect::back();
        }
        if ($request->get('tipo') == 7) {
            $todo = Dash::findOrFail($request->get('id'));
            $todo->comment = $request->get('comentarios');
            $todo->todo = '1';
            $todo->tel = $request->get('tel');
            $todo->usuario = $request->get('usuario');
            $todo->update();
            return Redirect::back();
        }
    }
    public function cale(Request $request)
    {
        if ($request->get('type') == null) {
            $cale = DB::table('dash')
                ->where('end', '!=', null)
                ->where('todo', '=', 2)
                ->select('start', 'end', 'comment as title', 'iddash as id')
                ->get();
            return Response::json($cale);
        } else {
            $type = $request->get('type');
            if ($type == 'new') {
                $event = new Dash;
                $event->comment = $request->get('title');
                $event->start = Carbon::now();
                $event->fecha = Carbon::now();
                $event->end = Carbon::now()->addHour();
                $event->todo = 2;
                $event->save();
                echo json_encode(array('status' => 'success'));
            }
            if ($type == 'resetdate') {
                $startdate = new Carbon($request->get('start'));
                $enddate = new Carbon($request->get('end'));
                $eventid = $request->get('eventid');

                $event = Dash::find($eventid);
                $event->start = $startdate;
                $event->fecha = $startdate;
                $event->end = $enddate;
                $event->save();
            }
            if ($type == 'changetitle') {
                $eventid = $request->get('eventid');
                $eventtitle = $request->get('title');

                $event = Dash::find($eventid);
                $event->comment = $eventtitle;
                $event->save();
                echo json_encode(array('status' => 'success'));
            }
            if ($type == 'remove') {
                $eventid = $request->get('eventid');
                $event = Dash::find($eventid);
                $event->delete();

                if ($event)
                    echo json_encode(array('status' => 'success'));
                else
                    echo json_encode(array('status' => 'failed'));
            }
        }
    }
    public function calr(Request $request)
    {
        if ($request->get('type') == null) {
            $calr = DB::table('dash')
                ->where('end', '!=', null)
                ->where('todo', '=', 3)
                ->select('start', 'end', 'comment as title', 'iddash as id')
                ->get();
            return Response::json($calr);
        } else {
            $type = $request->get('type');
            if ($type == 'new') {
                $event = new Dash;
                $event->comment = $request->get('title');
                $event->start = Carbon::now();
                $event->fecha = Carbon::now();
                $event->end = Carbon::now()->addHour();
                $event->todo = 3;
                $event->save();

                echo json_encode(array('status' => 'success'));
            }
            if ($type == 'resetdate') {
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
    public function calc(Request $request)
    {
        if ($request->get('type') == null) {
            $calc = DB::table('dash')
                ->where('end', '!=', null)
                ->where('todo', '=', 4)
                ->select('start', 'end', 'comment as title', 'iddash as id')
                ->get();
            return Response::json($calc);
        } else {
            $type = $request->get('type');
            if ($type == 'new') {
                $event = new Dash;
                $event->comment = $request->get('title');
                $event->start = Carbon::now();
                $event->fecha = Carbon::now();
                $event->end = Carbon::now()->addHour();
                $event->todo = 4;
                $event->save();

                echo json_encode(array('status' => 'success'));
            }
        }
    }
}

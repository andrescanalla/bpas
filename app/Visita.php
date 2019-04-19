<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class Visita extends Model
{
    protected $table= 'visitas';

    protected $primaryKey= 'id';

    public $timestramp= true;


    protected $fillable = [
      'implementador_id',
      'calendar_id',
      'localidad_id',
      'tipo_visita_id',
      'fecha',
      'comentarios',
      'calendar_update'      
    ];

    protected $guarded = [];

    public function tipo_visita() {

      return $this->belongsTo(TipoVisita::class);     
    }
    public function localidad() {

      return $this->belongsTo(Localidad::class);      
    }
    public function implementador() {

      return $this->belongsTo(Implementador::class);      
    }
    
    public function scopeFindByCalendarId($query, $nombre){
      
      return $query->where('calendar_id', $nombre);

    }

    public function scopeSearchText($query, $nombre){
      
      return $query->leftjoin('implementadores','visitas.implementador_id','=','implementadores.id')
        ->leftjoin('departamentos','implementadores.departamento_id','=','departamentos.id')
        ->leftjoin('localidades','visitas.localidad_id','=','localidades.id')
        ->leftjoin('tipo_visitas','visitas.tipo_visita_id','=','tipo_visitas.id')
        ->select('visitas.id','departamentos.nombre as nombreDepartamento', 'localidades.nombre as nombreLocalidad', 'implementadores.id as idImplementador', 'implementadores.nombre as nombreImplementador', 'tipo_visitas.id as idTipoVisita' , 'tipo_visitas.nombre as nombreTipoVisita' , 'fecha', 'comentarios')        
        ->where('implementadores.nombre','LIKE','%'.$nombre.'%')
        ->orwhere('localidades.nombre','LIKE','%'.$nombre.'%')
        ->orderBy('fecha','desc');
        

    }

    public function scopeTodo($query, $desde, $hasta){
      
      return $query->leftjoin('implementadores','visitas.implementador_id','=','implementadores.id')
        ->leftjoin('departamentos','implementadores.departamento_id','=','departamentos.id')
        ->leftjoin('localidades','visitas.localidad_id','=','localidades.id')
        ->leftjoin('tipo_visitas','visitas.tipo_visita_id','=','tipo_visitas.id')
        ->select('visitas.id','departamentos.nombre as nombreDepartamento', 'localidades.nombre as nombreLocalidad', 'implementadores.id as idImplementador', 'implementadores.nombre as nombreImplementador', 'tipo_visitas.id as idTipoVisita' , 'tipo_visitas.nombre as nombreTipoVisita' , 'fecha', 'comentarios')        
        ->where('fecha','>',Carbon::now()->subDays($desde))
        ->where('fecha','<',Carbon::now()->addDays($hasta))
        ->orderBy('fecha','desc');
        
        

    }

	
}



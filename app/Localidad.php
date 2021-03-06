<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    protected $table= 'localidades';

    protected $primaryKey= 'id';

    public $timestramp= true;


    protected $fillable = [
      'nombre',
      'departamento_id',
      'municipio', 
      'presentacion',
      'entrevista',
      'informe',
      'fecha_info',
      'veedor',
      'ordenanza',
      'problema',
      'sin_aplicacion',
      'aplicacion_controlada',
      'lng',
      'lat'
    ];

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at', 'fecha_info'];

    public function departamento() {

        return $this->belongsTo(Departamento::class);
        
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function visitas()
    {
        return $this->hasMany(Visita::class);
    }
    public function scopeFindByNombre($query, $nombre){
        return $query->where('nombre', 'LIKE','%'.$nombre.'%');
    }
    public function scopeFindByNombreLikeId($query, $nombre){
        return $query->where('nombre', $nombre);
    }
    public function scopeCountTotal($query, $filtro){
        return $query->where($filtro,1);
    }
    public function scopeCountDepartamento($query, $departamento, $filtro){
        return $query->leftjoin('departamentos','localidades.departamento_id','=','departamentos.id')
            ->select('localidades.nombre as nombreLocalidad','departamentos.nombre as nombreDepartamento', 'municipio', 'presentacion','entrevista','informe')
            ->where("departamentos.nombre", $departamento)
            ->where("localidades.$filtro",1);
            
    }
    public function scopeSearchText($query, $nombre){
      
        return $query->leftjoin('departamentos','localidades.departamento_id','=','departamentos.id')                        
          ->select('localidades.id','departamentos.implementador as nombreImplementador','departamentos.nombre as nombreDepartamento', 'localidades.nombre as nombreLocalidad', 'departamentos.id as idDepartamento',  'municipio', 'presentacion','entrevista','informe', 'ordenanza','fecha_info','veedor','problema','sin_aplicacion','aplicacion_controlada')                  
          ->where('departamentos.nombre','LIKE','%'.$nombre.'%')
          ->orwhere('localidades.nombre','LIKE','%'.$nombre.'%');
          
  
      }
      public function scopeFindbyDepartamento($query, $nombre){
      
        return $query->leftjoin('departamentos','localidades.departamento_id','=','departamentos.id')                        
          ->select('localidades.id','departamentos.nombre as nombreDepartamento', 'localidades.nombre as nombreLocalidad', 'departamentos.id as idDepartamento',  'municipio', 'presentacion','entrevista','informe', 'ordenanza','fecha_info','veedor','problema','sin_aplicacion','aplicacion_controlada')        
          ->where('departamentos.nombre','LIKE','%'.$nombre.'%');
          
          
  
      }

      public function scopeFindByNombreLocalidad($query, $nombre){
      
        return $query->leftjoin('departamentos','localidades.departamento_id','=','departamentos.id')
          ->leftjoin('implementadores','departamentos.id','=','implementadores.departamento_id')               
          ->select('localidades.id','implementadores.nombre as nombreImplementador','departamentos.nombre as nombreDepartamento', 'localidades.nombre as nombreLocalidad', 'departamentos.id as idDepartamento',  'municipio', 'presentacion','entrevista','informe', 'ordenanza','fecha_info','veedor','problema','sin_aplicacion','aplicacion_controlada')        
          ->where('localidades.nombre','LIKE','%'.$nombre.'%');
          
          
          
  
      }
      public function scopeFindById($query, $id){
      
        return $query->leftjoin('departamentos','localidades.departamento_id','=','departamentos.id')                       
          ->select('localidades.id','departamentos.implementador as nombreImplementador','departamentos.nombre as nombreDepartamento', 'localidades.nombre as nombreLocalidad', 'departamentos.id as idDepartamento',  'municipio', 'presentacion','entrevista','informe', 'ordenanza','fecha_info','veedor','problema','sin_aplicacion','aplicacion_controlada')                  
          ->where('localidades.id',$id);
          
          
  
      }

      public function scopeFiltroDepartamento($query, $departamento, $filtro){
          if($filtro=='presentacion'){
            return $query->leftjoin('departamentos','localidades.departamento_id','=','departamentos.id')
            ->select('localidades.lng','localidades.lat','localidades.nombre as nombreLocalidad','departamentos.nombre as nombreDepartamento', 'municipio', 'presentacion','entrevista','informe')
            ->where("departamentos.nombre", $departamento)
            ->where("localidades.$filtro",1)
            ->where("localidades.entrevista",0)
            ->where("localidades.informe",0);
          }
          if($filtro=='entrevista'){
            return $query->leftjoin('departamentos','localidades.departamento_id','=','departamentos.id')
            ->select('localidades.lng','localidades.lat','localidades.nombre as nombreLocalidad','departamentos.nombre as nombreDepartamento', 'municipio', 'presentacion','entrevista','informe')
            ->where("departamentos.nombre", $departamento)           
            ->where("localidades.$filtro",1)
            ->where("localidades.informe",0);
          }
          if($filtro=='restante'){
            return $query->leftjoin('departamentos','localidades.departamento_id','=','departamentos.id')
            ->select('localidades.lng','localidades.lat','localidades.nombre as nombreLocalidad','departamentos.nombre as nombreDepartamento', 'municipio', 'presentacion','entrevista','informe')
            ->where("departamentos.nombre", $departamento)           
            ->where("localidades.presentacion",0);            
          }
          else{          
            return $query->leftjoin('departamentos','localidades.departamento_id','=','departamentos.id')
                ->select('localidades.lng','localidades.lat','localidades.nombre as nombreLocalidad','departamentos.nombre as nombreDepartamento', 'municipio', 'presentacion','entrevista','informe')
                ->where("departamentos.nombre", $departamento)
                ->where("localidades.$filtro",1);
               
          }
            
    }
}

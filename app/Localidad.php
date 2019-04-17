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
    ];

    protected $guarded = [];

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
            ->select('departamentos.nombre as nombreDepartamento', 'municipio', 'presentacion','entrevista','informe')
            ->where("departamentos.nombre", $departamento)
            ->where("localidades.$filtro",1);
            
    }
    public function scopeSearchText($query, $nombre){
      
        return $query->leftjoin('departamentos','localidades.departamento_id','=','departamentos.id')         
          ->select('localidades.id','departamentos.nombre as nombreDepartamento', 'localidades.nombre as nombreLocalidad', 'departamentos.id as idDepartamento',  'municipio', 'presentacion','entrevista','informe')        
          ->where('departamentos.nombre','LIKE','%'.$nombre.'%')
          ->orwhere('localidades.nombre','LIKE','%'.$nombre.'%');
          
          
  
      }
}

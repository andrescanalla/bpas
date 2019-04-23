<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $table= 'comentarios';

    protected $primaryKey= 'id';

    public $timestramp= true;


    protected $fillable = [
      'comentarios',  
      'localidad_id',  
      'fecha',
      'inicial',
      'ordenanza',
      'veedor',
      'problema',            
      'sin_apliccion',         
      'apliccion_controlada',             
    ];

    protected $guarded = [];

    public function localidad() {

      return $this->belongsTo(Localidad::class);
      
    }

    public function scopeFindByLocalidad($query, $localidad){
      return $query->leftjoin('localidades','comentarios.localidad_id','=','localidades.id')         
          ->where("localidades.nombre", $localidad);
          
          
  }


}

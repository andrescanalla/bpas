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
      'fecha_comentario',                
    ];

    protected $guarded = [];

    public function localidad() {

      return $this->belongsTo(Localidad::class);
      
    }

    public function scopeFindByIdLocalidad($query, $id){
      return $query->leftjoin('localidades','comentarios.localidad_id','=','localidades.id')         
          ->where("localidad_id", $id);
          
          
  }


}

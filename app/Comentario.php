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

    protected $dates = ['created_at', 'updated_at', 'fecha_comentario'];

    public function localidad() {

      return $this->belongsTo(Localidad::class);
      
    }

    public function scopeFindByIdLocalidad($query, $id){
      return $query->leftjoin('localidades','comentarios.localidad_id','=','localidades.id')
          ->select('comentarios.id', 'comentarios', 'fecha_comentario', 'localidad_id')         
          ->where("localidad_id", $id);
          
          
  }


}

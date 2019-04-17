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
    ];

    protected $guarded = [];

    public function localidad() {

      return $this->belongsTo(Localidad::class);
      
  }

}

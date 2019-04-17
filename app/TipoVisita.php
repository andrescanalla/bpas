<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoVisita extends Model
{
    protected $table= 'tipo_visitas';

    protected $primaryKey= 'id';

    public $timestramp= true;


    protected $fillable = [
      'nombre',          
    ];

    protected $guarded = [];

    public function visitas()
    {
        return $this->hasMany(Visita::class);
    }
    public function scopeFindByNombre($query, $nombre){
      return $query->where('nombre', 'LIKE','%'.$nombre.'%');
  }

}

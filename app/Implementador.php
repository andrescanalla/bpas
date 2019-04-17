<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Implementador extends Model
{
    protected $table= 'implementadores';

    protected $primaryKey= 'id';

    public $timestramp= true;


    protected $fillable = [      
      'nombre',
      'departamento_id',
      'email',
      'telefono',            
    ];

    protected $guarded = [];

    public function departamento() {

      return $this->belongsTo(Departamento::class);      
    }
    public function visitas()
    {
        return $this->hasMany(Visita::class);
    }
    public function scopeFindByNombre($query, $nombre){
      return $query->where('nombre', $nombre);
    }
  

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table= 'departamentos';

    protected $primaryKey= 'id';

    public $timestramp= true;


    protected $fillable = [
      'nombre',
      'cantidad_localidades',          
    ];

    protected $guarded = [];

    public function localidades()
    {
        return $this->hasMany(Localidad::class);
    }

    public function implementadores()
    {
        return $this->hasMany(Implementador::class);
    }

    public function scopeFindDepartamentos($query){
        return $this;
    }

}

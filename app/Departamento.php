<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

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
        return $this->join('localidades','departamentos.id','=','localidades.departamento_id')
        ->whereNotIn('departamentos.id', [1])             
        ->select('departamentos.implementador as nombreImplementador','departamentos.id','departamentos.nombre as nombreDepartamento','departamentos.cantidad_localidades',
            DB::raw('sum(localidades.presentacion) as pre'),
            DB::raw('sum(localidades.entrevista) as entre'),
            DB::raw('sum(localidades.informe) as info')           
            )         
        ->groupBy('nombreImplementador','departamentos.id','nombreDepartamento','departamentos.cantidad_localidades')
        ->orderBY('nombreDepartamento');
    }

}

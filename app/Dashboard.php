<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class Dashboard extends Model
{
    protected $table= 'dash';

    protected $primaryKey= 'iddash';

    public $timestramp= true;


    protected $fillable = [
      'fecha',
      'Comment',
      'todo',      
    ];

    protected $guarded = [];

	public static function fechain($fechain){
	    $fecha="";
	    $carbon = new Carbon();
	    if(!empty($fechain)){
	        $fecha=$carbon->createFromFormat('Y-m-d',$fechain);
	        $fecha=$fecha->format('d/m');
	    }             	                 
	    return ($fecha);      
    }
    
    public static function mesLabel(){
        $m=1;
        $n=4;  
        $meses=array();
        $mStart=new Carbon();
        $mStart=$mStart->createFromFormat('Y-m-d','2018-10-01');      
        $mEnd=Carbon::now()->month;
        $mEnd=$mEnd+3;
        while ( $m<= $mEnd) {            
            $mes=$mStart->format('M');
            array_push($meses, $mes);
            $m=$m+1;
            $mStart->addMonths(1);
        };
        return ($meses);
    }
    public static function mesesData(){
        $año='2018';
        $m=10;
        $n=1;
        $meses=[];
        while ( $n<= 3) {
            $meses [$n]=["$año-$m-01","$año-$m-31"];
            $m=$m+1;
            $n=$n+1;
        };
        $m=1;
        $n=4;
        $año='2019';
        $mEnd=Carbon::now()->month;
        while ( $m<= $mEnd) {
            $meses [$n]=["$año-$m-01","$año-$m-31"];
            $m=$m+1;
            $n=$n+1;
        };
        return($meses);
    }
    public static function countTotal($filtro, $desde, $hasta){ 
        if($filtro=='presentacion programa' || $filtro=='entrevista' ){
            $visita=DB::table('visitas as vi')
                ->join('tipo_visitas as tipo','vi.tipo_visita_id','=','tipo.id')       
                ->select('vi.id','fecha','nombre', 'tipo_visita_id')           
                ->where('fecha','>',$desde)
                ->where('fecha','<',$hasta) 
                ->where('nombre', $filtro)                
                ->orwhere('nombre',"Presentacion y Entrevista")
                ->where('fecha','>',$desde)
                ->where('fecha','<',$hasta)       
                ->count();
            
        }
        else{
            $visita=DB::table('visitas as vi')
            ->join('tipo_visitas as tipo','vi.tipo_visita_id','=','tipo.id')       
            ->select('vi.id','fecha','nombre')           
            ->where('fecha','>',$desde)
            ->where('fecha','<',$hasta) 
            ->where('nombre',$filtro)               
            ->count();   
        }
       
       
        return ($visita);
    }

	public static function CountTipoVisita($filtro){       
		$meses=Dashboard::mesesData();        
        $visitas=[];
        foreach ($meses as $mes) {
            $visita=Dashboard::countTotal($filtro, $mes[0], $mes[1]);               
            array_push($visitas, $visita);
        }         
        return ($visitas);           
    }

    public static function CountTipoVisitaTotal($filtro){       
		$meses=Dashboard::mesesData();       
        $visitas=[];
        $n=1;
        foreach ($meses as $mes) {                  	
            $visita=Dashboard::countTotal($filtro, $mes[0], $mes[1]);
            if($n>1){              
                $visita=$visitas[$n-2]+$visita;
            }                 
            array_push($visitas, $visita);
            $n=++$n;           
         }            
        return ($visitas);           
    }
    
}



<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departamento;
use App\Dashboard;
use App\Localidad;
use App\Visita;
use App\TipoVisita;
use App\Implementador;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $departamentos=Departamento::FindDepartamentos()->get(); 
        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')            
            ->labels(Dashboard::mesLabel())
            ->datasets([  
                [
                    "label" => "Pres.",
                    'backgroundColor' => '#dff0d8',                 
                    'data' => Dashboard::CountTipoVisita('presentacion programa'),
                    'borderColor'=> '#2e8631',
                    'borderWidth'=> 1
                ], 
                [
                    "label" => "Entrev.",
                    'backgroundColor' => 'rgba(255, 206, 86, 0.3)',
                    'data' => Dashboard::CountTipoVisita('entrevista'),
                    'borderColor'=> 'rgba(255, 206, 86, 1)',
                    'borderWidth'=> 1

                ],
                [
                    "label" => "Inf.",
                    'backgroundColor' =>"#d9edf7",
                    'data' => Dashboard::CountTipoVisita('informe'),
                    'borderColor'=> '#31708f',
                    'borderWidth'=> 1

                ],        
                [
                    "label" => "Otro",
                    'backgroundColor' => "#ddd",
                    'data' => Dashboard::CountTipoVisita('otro'),
                    'borderColor'=> '#777',
                    'borderWidth'=> 1

                ]             
                
            ])
            ->optionsRaw("{
                scales: {
                    xAxes: [{
                        stacked: true
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                },
                legend: { position: 'bottom' },
                title: { display: true, text: 'Mensual' }
                
            }");
            
                
        return view('departamentos.index', compact('chartjs'),["departamentos"=>$departamentos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $numeros=Departamento::FindDepartamentos()->where('departamentos.id',$id)->first();         
        $departamento=Departamento::findOrFail($id); 
        $searchText=$departamento->nombre;       
        $localidades=Localidad::SearchText($departamento->nombre)->get();
        $visitas=Visita::SearchText($departamento->nombre)->get();
        $implementadores=Implementador::get();
        $tipoVisitas=TipoVisita::get();    
        
        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')            
            ->labels(Dashboard::mesLabel())
            ->datasets([  
                [
                    "label" => "Pres.",
                    'backgroundColor' => '#dff0d8',                 
                    'data' => Dashboard::CountTipoVisitaDepto('presentacion programa',$id),
                    'borderColor'=> '#2e8631',
                    'borderWidth'=> 1
                ], 
                [
                    "label" => "Entrev.",
                    'backgroundColor' => 'rgba(255, 206, 86, 0.3)',
                    'data' => Dashboard::CountTipoVisitaDepto('entrevista',$id),
                    'borderColor'=> '#ff8300',
                    'borderWidth'=> 1

                ],
                [
                    "label" => "Inf.",
                    'backgroundColor' =>"#d9edf7",
                    'data' => Dashboard::CountTipoVisitaDepto('informe',$id),
                    'borderColor'=> '#31708f',
                    'borderWidth'=> 1

                ],        
                [
                    "label" => "Otro",
                    'backgroundColor' => "#ddd",
                    'data' => Dashboard::CountTipoVisitaDepto('otro',$id),
                    'borderColor'=> '#777',
                    'borderWidth'=> 1

                ]             
                
            ])
            ->optionsRaw("{
                scales: {
                    xAxes: [{
                        stacked: true
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                },
                legend: { position: 'bottom' }
                
            }");

            

        return view('departamentos.show', compact('chartjs','tipoVisitas','implementadores','localidades','departamento','numeros', 'visitas', 'searchText'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

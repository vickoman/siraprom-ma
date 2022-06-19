<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


class IndicatorController extends Controller
{
            public function indicator(){

                $this->datos['user_info1'] = DB::table('projects')
    ->select('estado',DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"), DB::raw('count(*) as total'))
    ->groupBy('estado','new_date')
    ->orderBy('new_date')->get(); 
   // ->pluck('total','estado');


    $this->datos['promedio'] = DB::table('projects')
->select('created_at','updated_at', DB::raw('count(id) as `total`'),DB::raw("DATE_FORMAT(created_at, '%m-%Y') start_date"),  DB::raw("DATE_FORMAT(updated_at, '%m-%Y') end_date"),DB::raw("DATEDIFF(created_at , updated_at) as `days`"))->where('estado','=','Finalizado')
->groupby('created_at','updated_at','estado', 'days')->get();

    $this->datos['rev_cliente'] = DB::table('avances')
->select('created_at','updated_at', DB::raw('count(id) as `total`'),DB::raw("DATE_FORMAT(created_at, '%m-%Y') start_date"),  DB::raw("DATE_FORMAT(updated_at, '%m-%Y') end_date"),DB::raw("DATEDIFF(created_at , updated_at) as `days`"))->where('estado','=','Finalizado')
->groupby('created_at','updated_at','estado', 'days')->get();

                return view('indicator', $this->datos);
        } 


}

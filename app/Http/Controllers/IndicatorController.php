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


    $this->datos['user_info'] = DB::table('projects')
->select('estado', DB::raw('count(id) as `total`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"))
->groupby('created_at','estado')->get();
                return view('indicator', $this->datos);
        } 


}

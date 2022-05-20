<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


class IndicatorController extends Controller
{
            public function indicator(){

                $this->datos['user_info'] = DB::table('projects')
    ->select('estado', DB::raw('count(*) as total'))
    ->groupBy('estado')
    ->pluck('total','estado');

                return view('indicator', $this->datos);
        } 


}

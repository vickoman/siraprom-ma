<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Project;
use App\Models\Avance;


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
->select('created_at','updated_at', DB::raw('count(id) as `total`'),DB::raw("DATE_FORMAT(created_at, '%m-%Y') start_date"),  DB::raw("DATE_FORMAT(updated_at, '%m-%Y') end_date"),DB::raw("DATEDIFF(created_at , updated_at) as `days`"))->where('estado','=','Cambios Solicitados')
->groupby('created_at','updated_at','estado', 'days')->get();

    $this->datos['rev_dis'] = DB::table('avances')
->select('created_at','updated_at','project_id', DB::raw('count(id) as `total`'),DB::raw("DATE_FORMAT(created_at, '%m-%Y') start_date"),  DB::raw("DATE_FORMAT(updated_at, '%m-%Y') end_date"),DB::raw("DATEDIFF(created_at , updated_at) as `days`"))->where('estado','=','Cambios Solicitados')
->groupby('created_at','updated_at','project_id','estado', 'days')->get();


    $this->datos['primer_avance'] = DB::table('projects','avances')
->select('created_at','avances.created_at', DB::raw('count(id) as `total`'),DB::raw("DATE_FORMAT(created_at, '%m-%Y') start_date"),  DB::raw("DATE_FORMAT(avances.created_at, '%m-%Y') s_star_date"),DB::raw("DATEDIFF(created_at , avances.created_at) as `days`"))->where('estado','!=','Nuevo')
->groupby('created_at','avances.created_at','estado', 'days')->get();

                return view('indicator', $this->datos);
        } 

        public function GetIndicadorProjectPrimerAvanceTiempoPromedio(Request $request) {

            $SQL_QUERY =  <<<EOD
                SELECT
                    ROUND(AVG(fisrt_avance_in_days), 1) as averga_in_days
                    FROM (SELECT DATE(p.created_at)   as project_date_started,
                                DATEDIFF((select created_at from avances where project_id = p.id ORDER BY created_at DESC LIMIT 1),
                                        created_at) as fisrt_avance_in_days
                        FROM projects p) avgs;
                EOD;

            $response = \DB::select($SQL_QUERY);
            return floatval($response[0]->averga_in_days);
        }


}

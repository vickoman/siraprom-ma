<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Models\Project;
use App\Models\Avance;
class IndicatorController extends Controller
{

                function __construct(){
        $this->middleware('permission:mostrar-indicadores', ['only' => ['indicator']]);
    }
    public function indicator(Request $request)
    {



        if ($request->isMethod('post'))
        {
            $this->validate($request, ['fecha_inicio' => 'required_with_all:fecha_final', 'fecha_final' => 'required_with_all:fecha_inicio', ]);
            $fecha_inicial = date('Y-m-d 00:00:00', strtotime($request->fecha_inicio));
            $fecha_final = date('Y-m-d 00:00:00', strtotime($request->fecha_final));
        }


        $this->datos['user_info1'] = DB::table('projects')
            ->select('estado', DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date") , DB::raw('count(*) as total'))
            ->groupBy('estado', 'new_date');
        if ($request->isMethod('post'))
        {
            if ($fecha_inicial)
            {
                $this->datos['user_info1'] = $this->datos['user_info1']
                    ->whereBetween('created_at', [$fecha_inicial, $fecha_final]);
            }
        }
        $this->datos['user_info1'] = $this->datos['user_info1']
            ->orderBy('new_date')
            ->get();





        $this->datos['promedio'] = DB::table('projects')
            ->select('created_at', 'updated_at', DB::raw('count(id) as `total`') , DB::raw("DATE_FORMAT(created_at, '%m-%Y') start_date") , DB::raw("DATE_FORMAT(updated_at, '%m-%Y') end_date") , DB::raw("DATEDIFF(created_at , updated_at) as `days`"))
            ->where('estado', '=', 'Finalizado');
        if ($request->isMethod('post'))
        {
            if ($fecha_inicial)
            {
                $this->datos['promedio'] = $this->datos['promedio']
                    ->whereBetween('created_at', [$fecha_inicial, $fecha_final]);
            }
        }
        $this->datos['promedio'] = $this->datos['promedio']
            ->groupby('created_at', 'updated_at', 'estado', 'days')
            ->get();




        $this->datos['rev_cliente'] = DB::table('avances')
            ->select('created_at', 'updated_at', DB::raw('count(id) as `total`') , DB::raw("DATE_FORMAT(created_at, '%m-%Y') start_date") , DB::raw("DATE_FORMAT(updated_at, '%m-%Y') end_date") , DB::raw("DATEDIFF(created_at , updated_at) as `days`"))
            ->where('estado', '=', 'Cambios Solicitados');
        if ($request->isMethod('post'))
        {
            if ($fecha_inicial)
            {
                $this->datos['rev_cliente'] = $this->datos['rev_cliente']
                    ->whereBetween('created_at', [$fecha_inicial, $fecha_final]);
            }
        }
        $this->datos['rev_cliente'] = $this->datos['rev_cliente']
            ->groupby('created_at', 'updated_at', 'estado', 'days')
            ->get();




        $this->datos['rev_dis'] = DB::table('avances')
            ->select('created_at', 'updated_at', 'project_id', DB::raw('count(id) as `total`') , DB::raw("DATE_FORMAT(created_at, '%m-%Y') start_date") , DB::raw("DATE_FORMAT(updated_at, '%m-%Y') end_date") , DB::raw("DATEDIFF(created_at , updated_at) as `days`"))
            ->where('estado', '=', 'Cambios Solicitados');
        if ($request->isMethod('post'))
        {
            if ($fecha_inicial)
            {
                $this->datos['rev_dis'] = $this->datos['rev_dis']
                    ->whereBetween('created_at', [$fecha_inicial, $fecha_final]);
            }
        }
        $this->datos['rev_dis'] = $this->datos['rev_dis']
            ->groupby('created_at', 'updated_at', 'project_id', 'estado', 'days')
            ->get();


/*

        $this->datos['primer_avance'] = DB::table('projects', 'avances')
            ->select('created_at', 'avances.created_at', DB::raw('count(id) as `total`') , DB::raw("DATE_FORMAT(created_at, '%m-%Y') start_date") , DB::raw("DATE_FORMAT(avances.created_at, '%m-%Y') s_star_date") , DB::raw("DATEDIFF(created_at , avances.created_at) as `days`"))
            ->where('estado', '!=', 'Nuevo');
        if ($request->isMethod('post'))
        {
            if ($fecha_inicial)
            {
                $this->datos['primer_avance'] = $this->datos['primer_avance']
                    ->whereBetween('created_at', [$fecha_inicial, $fecha_final]);
            }
        }
        $this->datos['primer_avance'] = $this->datos['primer_avance']
            ->groupby('created_at', 'avances.created_at', 'estado', 'days')
            ->get();
*/




        $SQL_QUERY = <<<EOD
SELECT
ROUND(AVG(fisrt_avance_in_days), 1) as averga_in_days
FROM (SELECT DATE(p.created_at)   as project_date_started,
DATEDIFF((select created_at from avances where project_id = p.id ORDER BY created_at DESC LIMIT 1),
created_at) as fisrt_avance_in_days
FROM projects p 

) avgs;
EOD;
        $response = \DB::select($SQL_QUERY);
        $this->datos['primer_cambio'] = collect($response[0]);
                /*       if ($request->isMethod('post'))
        {
            if ($fecha_inicial)
            {
                $this->datos['primer_cambio'] = $this->datos['primer_cambio']
                    ->whereBetween('created_at', [$fecha_inicial, $fecha_final]);
            }

        } */
       




        $this->datos['num_com'] = DB::table('avances')
            ->select('project_id', 'estado', 'comentarios', DB::raw('count(id) as `total`') , DB::raw("DATE_FORMAT(created_at, '%m-%Y') start_date") , DB::raw("DATE_FORMAT(updated_at, '%m-%Y') end_date"))
            ->where('estado', '!=', 'Nuevo');
        if ($request->isMethod('post'))
        {
            if ($fecha_inicial)
            {
                $this->datos['num_com'] = $this->datos['num_com']
                    ->whereBetween('created_at', [$fecha_inicial, $fecha_final]);
            }
        }
        $this->datos['num_com'] = $this->datos['num_com']
            ->groupby('project_id', 'created_at', 'updated_at', 'estado', 'comentarios')
            ->get();




        return view('indicator', $this->datos);
    }
}


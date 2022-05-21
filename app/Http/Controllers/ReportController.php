<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Project;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Auth;
use App\Exports\UsersExport;
use App\Exports\ProjectsExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function report(){
                return view('report');
        } 

    public function reportPost(Request $request){

        $this->validate($request, [
                        'origen' => 'required',
                        'fecha_inicio' => 'required_with_all:fecha_final',
                        'fecha_final' => 'required_with_all:fecha_inicio',
                ]);

$fecha_inicial=$request->fecha_inicio;
$fecha_final=$request->fecha_final;
$origen=$request->origen;
if ($origen=="Proyectos") {
return Excel::download(new ProjectsExport($fecha_inicial,$fecha_final), 'projects.xlsx');
}
if ($origen=="Usuarios") {
return Excel::download(new UsersExport($fecha_inicial,$fecha_final), 'users.xlsx');
}

     //   return view('report',compact('data'))->with('success', 'llegue al otro lado ya es un triunfo verdad jajaja');

    }
}

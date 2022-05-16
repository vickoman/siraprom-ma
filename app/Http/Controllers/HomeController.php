<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Avance;
use Spatie\Permission\Models\Role;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->datos['totalUsers']       = User::count('id');
        $this->datos['totalUsersAdmin']       = User::whereHas("roles", function($q){ $q->where("name", "Super-Admin"); })->get()->count('id');
        $this->datos['totalUsersDisenador']       = User::whereHas("roles", function($q){ $q->where("name", "Disenador"); })->get()->count('id');
        $this->datos['totalUsersCliente']   = User::whereHas("roles", function($q){ $q->where("name", "Cliente"); })->get()->count('id');
        $this->datos['ProyectosNuevos']    = Project::where("estado", "Nuevo")->get()->count('id');
        $this->datos['ProyectosProgreso']    = Project::where("estado", "En Progreso")->get()->count('id');
        $this->datos['ProyectosFinal']    = Project::where("estado", "Finalizado")->get()->count('id');
        $this->datos['totalProjects']    = Project::count('id');

        $this->datos['totalAvance']    = Avance::count('id');
        $this->datos['AvancesNuevos']    = Avance::where("estado", "")->get()->count('id');
        $this->datos['AvancesRevisados']    = Avance::where("estado", "Revisado")->get()->count('id');
        $this->datos['AvancesCambios']    = Avance::where("estado", "Cambios Solicitados")->get()->count('id');
        if(Auth::user()->hasRole('Disenador')){
             return redirect('/projects');
          }
        if(Auth::user()->hasRole('Cliente')){
             return redirect('/projects');
          }

        return view('home',$this->datos);
    }
}

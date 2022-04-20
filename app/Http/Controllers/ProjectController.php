<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class ProjectController extends Controller
{
    private $path = 'projects';
    function __construct(){
        $this->middleware('permission:project-list|project-create|project-edit|project-delete', ['only' => ['index','show']]);
        $this->middleware('permission:project-create', ['only' => ['create','store']]);
        $this->middleware('permission:project-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:project-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::latest()->paginate(5);
        return view($this->path.'.index',compact('projects'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $permission = Permission::get();
        $designers = User::whereHas("roles", function($q){ $q->where("name", "Designer"); })->get();
        $clients = User::whereHas("roles", function($q){ $q->where("name", "Client"); })->get();
        return view($this->path.'.create',compact('permission', 'designers', 'clients'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:projects,title',
            'description' => 'required',
            'eta' => 'required',
            'client_id' => 'required',
            'designer_id' => 'required',
        ]);

        $project = Project::create($request->all());

        return redirect()->route('projects.index')
            ->with('success','Project created successfully.');
    }

    public function show($id)
    {
        $project = Project::find($id);
        $designer = User::find($project->designer_id);
        $client = User::find($project->client_id);

        return view($this->path.'.show',compact('project','designer','client'));
    }

    public function edit($id)
    {
        $project = Project::find($id);
        $designer = User::find($project->designer_id);
        $client = User::find($project->client_id);
        $designers = User::whereHas("roles", function($q){ $q->where("name", "Designer"); })->get();
        $clients = User::whereHas("roles", function($q){ $q->where("name", "Client"); })->get();
        return view($this->path.'.edit',compact('project', 'designers', 'designer',  'clients', 'client'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'eta' => 'required',
            'client_id' => 'required',
            'designer_id' => 'required',
        ]);

        $project = Project::find($id);
        $project->update($request->all());

        return redirect()->route($this->path.'.index')
            ->with('success','Project updated successfully.');
    }

    public function destroy($id)
    {
        Project::find($id)->delete();
        return redirect()->route($this->path.'.index')
            ->with('success','Project deleted successfully');
    }
}

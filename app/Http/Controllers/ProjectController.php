<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Avance;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Auth;

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

        $projects = Project::sortable()->latest();
         if(Auth::user()->hasRole('Disenador')){
              $projects=$projects->where('designer_id', Auth::user()->id);
          }
        if(Auth::user()->hasRole('Cliente')){
              $projects=$projects->where('client_id', Auth::user()->id);
          }
          $projects = $projects->paginate(5);
        return view($this->path.'.index',compact('projects'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $permission = Permission::get();
        $designers = User::whereHas("roles", function($q){ $q->where("name", "Disenador"); })->get();
        $clients = User::whereHas("roles", function($q){ $q->where("name", "Cliente"); })->get();
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
            'estado' => 'required',
            'final_file' => 'nullable|file|mimes:zip|max:4096',
        ]);
        $project=new Project();
        $project->title = $request->title;
        $project->description = $request->description;
        $project->eta = $request->eta;
        $project->client_id = $request->client_id;
        $project->designer_id = $request->designer_id;
        $project->estado = $request->estado;

        $project->save();

if($request->has('final_file')){
        $id=$project->id;
        $project = Project::find($id);
        $img_name= "proyecto_".$id.".zip";
        $path = Storage::putFileAs('public/zips', request()->file('final_file'), $img_name);
        $project->final_file = $img_name;
        $project->update();
}

        return redirect()->route('projects.index')
            ->with('success','Project creado correctamente.');
    }

    public function show($id)
    {

        $project = Project::find($id);

        if ((Auth::user()->id==$project->designer_id) or (Auth::user()->id==$project->client_id)){
        $designer = User::find($project->designer_id);
        $client = User::find($project->client_id);
        $avances = Avance::where("project_id","=",$id) ->orderByDesc('created_at')->paginate(20);
        return view($this->path.'.show',compact('project','designer','client', 'avances'));
    } else {
            abort(403);
        }
    }

    public function edit($id)
    {
        $project = Project::find($id);
        $designer = User::find($project->designer_id);
        $client = User::find($project->client_id);
        $designers = User::whereHas("roles", function($q){ $q->where("name", "Disenador"); })->get();
        $clients = User::whereHas("roles", function($q){ $q->where("name", "Cliente"); })->get();


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
            'estado' => 'required',
            'final_file' => 'nullable|mimes:zip|max:4096',
        ]);

        $project = Project::find($id);
        if($request->has('final_file')){
          //  $request->final_file->store('zips');
        $img_name= "proyecto_".$id.".zip";
        $path = Storage::putFileAs('public/zips', request()->file('final_file'), $img_name);
        $request->final_file=$img_name;
}
//        $project->update($request->all());


        $project->title = $request->title;
        $project->description = $request->description;
        $project->eta = $request->eta;
        $project->client_id = $request->client_id;
        $project->designer_id = $request->designer_id;
        $project->estado = $request->estado;
        $project->update();

        return redirect()->route($this->path.'.index')
            ->with('success','Proyecto actualizado correctamente.');
    }

    public function destroy($id)
    {
        Project::find($id)->delete();
        return redirect()->route($this->path.'.index')
            ->with('success','Proyecto borrado correctamente');
    }

    public function sendPost(Request $request){

        $this->validate($request, [
                        'email' => 'required|email',
                        'subject' => 'required',
                        'comment' => 'required'
                ]);
                $subject =$request->subject;
                $email=$request->email;
                $comment=$request->comment ;

        Mail::send('email', [
                'email' => $email,
                'subject' => $subject,
                'comment' => $comment ],
                function ($message) use ($email, $subject) {
                        $message->from('dev@twm.ec', 'TWM');
                        $message->to($email)
                                ->subject($subject);
        });

        return back()->with('success', 'Notificacion enviada correctamente');

    }
    
}

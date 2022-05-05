<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Avance;
use App\Models\Project;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;


class AvanceController extends Controller
{
        private $path = 'avances';
    function __construct(){
        $this->middleware('permission:avance-list|avance-create|avance-edit|avance-delete', ['only' => ['index','show']]);
        $this->middleware('permission:avance-create', ['only' => ['create','store']]);
        $this->middleware('permission:avance-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:avance-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $projects = Project::latest();
         if(Auth::user()->hasRole('Disenador')){
              $projects=$projects->where('designer_id', Auth::user()->id)->pluck('id', 'name');

          }
        if(Auth::user()->hasRole('Cliente')){
              $projects=$projects->where('client_id', Auth::user()->id)->pluck('id', 'name');
          }


            $avances = Avance::latest();
         if(Auth::user()->hasRole('Disenador')){
              $avances=$avances->whereIn('project_id', $projects->id)->paginate(5);
          }
        if(Auth::user()->hasRole('Cliente')){
              $avances=$avances->whereIn('project_id', $projects->id)->paginate(5);
          }
          $avances = $avances->paginate(5);
        return view($this->path.'.index',compact('avances'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::get();
        return view($this->path.'.create',compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
              $this->validate($request, [
            'name' => 'required|unique:avances,name',
            'description' => 'required',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'project_id' => 'required',
        ]);
        
 
         //$path = $request->file('file')->store('public/images');
         //$request->file = $path;

              $project_id= $request->project_id;

        //$path = $request->file('file')->getClientOriginalName()->store('public/images');
        $path = $request->file('file')->storeAs('public/images', time().'.jpg');
        $namefile= time().'.jpg';
        $post = new Avance;
        $post->name = $request->name;
        $post->description = $request->description;
        $post->file = $namefile;
        $post->project_id = $project_id;
        $post->save();

            return redirect('projects/'.$project_id)->with('success','Avance agregado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Avance  $avance
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $avance = Avance::find($id);
        return view($this->path.'.show',compact('avance'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Avance  $avance
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $avance = Avance::findOrFail($id);
        return view($this->path.'.edit', compact('avance'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Avance  $avance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

                $post = Avance::find($id);

        if($request->file != ''){     
          //codigo para borrar un archivo 
            $base_path='storage/images/';
          if($post->file != ''  && $post->file != null){
               $file_old = $base_path.$post->file;
               unlink($file_old);
          }
        $path = $request->file('file')->storeAs('public/images', time().'.jpg');
        $namefile= time().'.jpg';
        $post->file = $namefile;
}
        $post->name = $request->name;
        $post->description = $request->description;
        $post->update();

            return redirect()->back()->with('success','Avance actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Avance  $avance
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          try {
            $avance = Avance::findOrFail($id);
           if($request->file != ''){     
          //codigo para borrar un archivo 
            $base_path='storage/images/';
          if($post->file != ''  && $post->file != null){
               $file_old = $base_path.$post->file;
               unlink($file_old);
          }
      }
            $avance->delete();
            //return redirect()->route('avances.index')->with('success','User borrado correctamente');
            //return redirect('projects/')->with('success','Avance eliminado correctamente.');
            return redirect()->back()->with('success','Avance eliminado correctamente.');

        }catch(Exception $e) {
            return "Fatal error - " . $e->getMessage();
        }
    }
}

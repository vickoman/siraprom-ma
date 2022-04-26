<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Avance;
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
        //
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
            'file' => 'required',
            'project_id' => 'required',
        ]);
              $project_id= $request->project_id;
        $avance = Avance::create($request->all());

     //   return redirect()->route('projects.index'.'/'.[$project_id])
      //      ->with('success','Avance agregado correctamente.');
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
    public function update(Request $request, Avance $avance)
    {
        //
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
            $avance->delete();
            //return redirect()->route('avances.index')->with('success','User deleted successfully');
            return redirect('projects/'.$project_id)->with('success','Avance eliminado correctamente.');
        }catch(Exception $e) {
            return "Fatal error - " . $e->getMessage();
        }
    }
}

<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Avance;
use App\Models\Project;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Mail;


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
        $namefile= time().'.jpg';
        $path = $request->file('file')->storeAs('public/images', $namefile);
       // $namefile= time().'.jpg';
        $post = new Avance;
        $post->name = $request->name;
        $post->description = $request->description;
        $post->estado = $request->estado;
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
    $project_parent = Project::find($avance->project_id);
        if ((Auth::user()->id==$project_parent->designer_id) or (Auth::user()->id==$project_parent->client_id)or (Auth::user()->hasRole('Super-Admin'))){
        return view($this->path.'.show',compact('avance'));
    }else {
            abort(403);
        }
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
        $namefile= time().'.jpg';
        $path = $request->file('file')->storeAs('public/images', $namefile);

        $post->file = $namefile;
}
        $post->name = $request->name;
        $post->description = $request->description;
        $post->estado = $request->estado;
        $post->update();

            return redirect()->back()->with('success','Avance actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Avance  $avance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
          try {
            $avance = Avance::findOrFail($id);
           if($avance->file != ''){     
          //codigo para borrar un archivo 
            $base_path='storage/images/';
          if($avance->file != ''  && $avance->file != null){
               $file_old = $base_path.$avance->file;
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

    /**
     *  Guardar comentarios de forma asincrona
     */
    public function save_comment(Request $request){
        try {
            $avance = Avance::findOrFail($request->id);
            $avance->comentarios = $request->data;
            $avance->estado = $request->estado;
            $avance->update();

                $check_subj =$request->estado;

                switch ($check_subj) {
                    case 'Revisado':
                        $subject= "Un cliente ha revisado y dado ok en un avance";
                        $content="Hola disenador el cliente del proyecto ha cambiado el estado a revisado al avance ". route('projects.show',$avance->project_id);
                        break;
                    case 'Cambios Solicitados':
                        $subject= "Un cliente ha solicitado cambios de un avance";
                        $content="Hola disenador, se ha solicitado cambios en un avance, revisalo en ". route('avances.show', $request->id);
                        break;
                    case 'Proyecto Finalizado':
                        $subject= "Un cliente ha solicitado finalizar el proyecto";
                        $content="Hola disenador el cliente del proyecto ha solicitado el cierre del proyecto y ha pedido la subida de los archivos finales ". route('projects.show',$avance->project_id);
                        break;
                }
                $dis=Project::where("id","=",$avance->project_id)->value('designer_id');
                $email=User::where("id","$dis")->value('email');
        Mail::send('email', [
                'email' => $email,
                'subject' => $subject,
                'comment' => $content ],
                function ($message) use ($email, $subject) {
                        $message->from('dev@twm.ec', 'TWM');
                        $message->to($email)
                                ->subject($subject);

            return "saved!";
        });

        } catch(Exception $e) {
            return "Fatal error - " . $e->getMessage();
        }
    }
}

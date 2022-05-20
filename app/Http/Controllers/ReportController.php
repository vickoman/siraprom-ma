<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Project;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Auth;

class ReportController extends Controller
{
    public function report(){
                $data = Project::sortable()->latest();
                return view('report',compact('data'));
        } 

    public function reportPost(Request $request){

        $this->validate($request, [
                        'origen' => 'required'
                ]);
        $data = Project::sortable()->latest();
              //  $subject =$request->subject;


        return view('report',compact('data'))->with('success', 'llegue al otro lado ya es un triunfo verdad jajaja');

    }


}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use DB;
use Exception;
use Hash;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    private $path = 'user';
    // show index
    public function index() {
        $data = User::all(); // Get users except logged user
        return view($this->path.'.index', compact('data'));
    }
    // show create form
    public function create() {
        $roles = Role::pluck('name','name')->all();
        return view($this->path.'.create', compact('roles'));
    }

    // Show user details
    public function show($id)
    {
        $user = User::find($id);
        return view($this->path.'.show',compact('user'));
    }

    // Save user from form
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'roles' => 'required'
        ]);
        /**
         * Registrar usuario
         */
        try {
            $input = $request->all();
            $input['password'] = Hash::make($input['password']);

            $user = User::create($input);
            $user->assignRole($request->input('roles'));

            return redirect()->route('users.index')
                        ->with('success','User created successfully');

        }catch(Exception $e) {
            return "Fatal error - " . $e->getMessage();
        }
    }

    // Edit
    public function edit($id) {
        $user = User::findOrFail($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view($this->path.'.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'roles' => 'required'
        ]);

        try {
            $input = $request->all();
            if(!empty($input['password'])){ 
                $input['password'] = Hash::make($input['password']);
            }else{
                $input = Arr::except($input,array('password'));    
            }
                $user = User::find($id);

                $user->update($input);
            DB::table('model_has_roles')->where('model_id',$id)->delete();
            $user->assignRole($request->input('roles'));

            return redirect()->route('users.index')
                            ->with('success','User updated successfully');
        }catch(Exception $e) {
            return "Fatal error - " . $e->getMessage();
        }
    }

    public function destroy($id) {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
        }catch(Exception $e) {
            return "Fatal error - " . $e->getMessage();
        }
    }
}



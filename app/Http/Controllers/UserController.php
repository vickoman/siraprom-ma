<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class UserController extends Controller
{
    private $path = 'user';
    // show index
    public function index() {
        $data = User::all()->except(auth()->id()); // Get users except logged user
        return view($this->path.'.index', compact('data'));
    }
    // show create form
    public function create() {
        return view($this->path.'.create');
    }

    // Save user from form
    public function store(Request $request) {
        /**
         * Registrar usuario
         */
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();

            return redirect()->route('users.index');
        }catch(Exception $e) {
            return "Fatal error - " . $e->getMessage();
        }
    }

    // Edit
    public function edit($id) {
        $user = User::findOrFail($id);
        return view($this->path.'.edit', compact('user'));
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);
        try {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            return redirect()->route('users.index');
        }catch(Exception $e) {
            return "Fatal error - " . $e->getMessage();
        }
    }

    public function destroy($id) {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('users.index');
        }catch(Exception $e) {
            return "Fatal error - " . $e->getMessage();
        }
    }
}



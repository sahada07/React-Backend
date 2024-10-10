<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // GET /api/users
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    // POST /api/users
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5',
            //'name' => 'required|string',
            'first_name'=>'required|string',
           'last_name'=>'required|string',
           //'phone_number'=>'required|string'


        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'first_name'=>$request->first_name,
           'last_name'=>$request ->last_name,
           //'phone_number'=>$request ->phone_number


            //'name' => $request->name,
        ]);

        return response()->json($user, 201);
    }

    // GET /api/users/{id}
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user, 200);
    }

    // PUT /api/users/{id}
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $request->validate([
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:5',
            'first_name'=>'required|string',
            'last_name'=>'required|string',
            //'phone_number'=>'required|string'
 
            //'name' => 'string',
        ]);

        $user->update([
            'email' => $request->email ?? $user->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'first_name'=>$request->first_name ?? $user->first_name,
            'last_name'=>$request ->last_name ?? $user->last_name,
           // 'phone_number'=>$request ->phone_number ?? $user->phone_number,
            
 
 
            //'name' => $request->name ?? $user->name,
        ]);

        return response()->json($user, 200);
    }

    // DELETE /api/users/{id}
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }

    
}
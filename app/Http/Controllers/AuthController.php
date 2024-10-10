<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\ApiLoginRequest;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Password;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * 
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            //'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5|confirmed',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone_number' => 'required|string',
            'address' => 'required|string',
        ]);

        $user = User::create([
            //'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'address' => $validatedData['address'],
            'phone_number' => $validatedData['phone_number'],
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'registration successful',
            'user' => $user,
             'token' => $token], 201);
    }



    public function login(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    
        // Attempt to authenticate the user with the provided credentials
        if (!Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']])) {
            // Return an error response if authentication fails
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    
        // Get the authenticated user
        $user = Auth::user();
    
        // Generate a new token for the user
        $token = $user->createToken('authToken')->plainTextToken;
    
        // Return the user and the token as the response
        return response()->json([
            'message' => 'login successful',
            'user' => $user, 
            'token' => $token], 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function logout()
    {
        //
        request()->user()->tokens()->delete();
        return [
            'message' => 'logout successful',
        ];
    }

    

}
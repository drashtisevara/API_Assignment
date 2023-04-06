<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use App\Jobs\UpdateIsNewColumnJob;



class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if(User::where('email' , $request->email)->first()){
            return response([
                'message'=>'Email already exist',
                'status'=>'failed'
            ], 200);
        }

        // Create and save new user

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_new' => 1,
        ]);
        $user->roles()->sync($request->input('roles'));
        $token = $user->createToken($request->email)->plainTextToken;
        Mail::to($user->email)->send(new WelcomeMail($user));
        Mail::to($user->email)->send(new WelcomeMail($user));

        // Dispatch the job to update the is_new field of new users
        dispatch(new UpdateIsNewColumnJob);
        return response()->json([
            'token' => $token,
            'user' => $user,
            'status' => 'success',
            'message' => 'User Registered successfully',
        ],201 );
    }

    /**
     * Login user and create token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password'=> 'required'
        ]);
        // Check if user credentials are valid
        $user = User::where('email' , $request->email)->first();
        if($user && Hash::check($request->password, $user->password)){
            $token = $user->createToken($request->email)->plainTextToken;
            $user->roles()->sync($request->input('roles'));
            return response()->json([
                'status' => 'success',
                'message' => 'User logged in successfully',
                'token' => $token
            ], 200);
        }
        return response([
            'message' => 'The provided Credentials are incorrect',
            'status' => 'failed',
        ], 401);

        }

    public function logout()
    {
        auth()->user()->tokens()->delete();
    

        return response()->json([
            'status' => 'success',
            'message' => 'User logged out successfully'
        ], 200);
    }

    public function logged_user()
    {
        $loggeduser = auth()->user();
    

        return response()->json([
            'user' => $loggeduser,
            'status' => 'success',
            'message' => 'Logged User Data'
        ], 200);
    }

    public function change_password(Request $request){
        $request->validate([
            'password' => 'required|confirmed',
        ]);
        $loggeduser = auth()->user();
        $loggeduser->password = Hash::make($request->password);
        $loggeduser->save();
        return response([
            'message' => 'Password Changed Successfully',
            'status'=>'success'
        ], 200);
    }

    public function userRole(Request $request)
    {
        $user = User::find($request->user_id);
        $user->roles()->attach($request->role_id);
        return response()->json(['message' => 'Role attached to user'], 201);
    }

}
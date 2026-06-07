<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $request->validate([
            "email"=> "required|string|min:3",
            "password"=>"required|string|min:5"
        ]);

        $users = User::all();
        foreach($users as $user){
            if($user->email == $request->email && Hash::check($request->password , $user->password)){
                return response()->json([
                    "data"=> 'the credentails you added matches to this user '.$user->name,
                ]);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            "email"=> "required|string|min:5",
            "password"=>"required|string|min:5"
        ],[
          "email.required"=> "the email is required, please enter your email address",
          "email.string"=> "the email must be a text",
          "password.min"=> "the password must be at least 5 characters"  
        ]);
     
      $user =   User::where('email', $request->email)->first();
      if($user && Hash::check($request->password, $user->password)){
         $token =  $user->createToken('auth_token')->plainTextToken;
        return  response()->json([
        "data"=> $token,
        "success"=>true
      ]);
      }
      else{
        return response()->json([
            "data"=>"something went wrong",
            "success"=> false
        ]);
      }

      
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    public function register(){
        return response()->json([
            "data"=>"something"
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

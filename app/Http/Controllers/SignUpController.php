<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class SignUpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $newUser = $request->validate([
                "name" => "required|string|min:3",
                "email"=> "required|string|min:5",
                "password"=> "required|string|min:6",
                "phone_number" => "required|string|min:10|max:14",
            ],[
                "name.string" => "The name must be a text",
                "name.required"=> "Please fill the name field",
                "phone_number.required"=> "Enter your phone number please",
            ]);
            $user = User::create([
                "name"=> $newUser['name'],
                "email"=> $newUser["email"],
                "phone_number" => $newUser['phone_number'],
                "password"=> bcrypt($newUser['password']),
            ]);
            $token = $user->createToken("auth_token")->plainTextToken;
            return response()->json([
                "message" => $token,
                "success" => true,
            ]);
        }
        catch(Exception $e){
            return response()->json([
                "message" => $e->getMessage(),
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

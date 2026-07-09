<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::where('role','client')->orderBy('name','asc')->paginate(15);
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Gate::authorize('create');
        if(Gate::allows('create')){
    
        }
        else{
            abort(403);
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

    // Count current month users
    public function currentMonthUsers(){
        try{
        $users = User::whereDate("created_at","<=",now())->whereDate("created_at",">",Carbon::now()->subDays(30))->count();
        return response()->json([
            "users" => $users
        ]);
        }catch(Exception $e){
            return response()->json([
                "users" => $e->getMessage()
            ]);
        }
    }

    // count previous month users
    public function getPreviousMonthUsers(){
        try{
            $users = User::whereDate("created_at","<=",Carbon::now()->subDays(30))->whereDate("created_at",">",Carbon::now()->subDays(60))->count();
            return response()->json([
                "users" => $users
            ]);
        }catch(Exception $e){
            return response()->json([
                "users" => $e->getMessage()
            ]);
        }
    }
}

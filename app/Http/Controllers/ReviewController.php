<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $reviews = Review::with(['product','user'])->get();
       $reviews->load(['product','user']);
       return ReviewResource::collection($reviews);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddReviewRequest $request)
    {
        try{
            $review = Review::create($request->validated());
            $review->load(['product','user']);
            return new ReviewResource($review);
        }
        catch(Exception $err){
            return response()->json([
                "message" => $err->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
           $review = Review::findOrFail($id);
           $review->load(['user','product']);
           return new ReviewResource($review);
        }
        catch(Exception $err){
            return response()->json([
                "message" => $err->getMessage()
            ]);
        }
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

    // Count the current month's reviews
    public function currentMonthReviews(){
        try{
        $reviews = Review::whereDate("created_at","<=",Carbon::today())->whereDate("created_at",">",Carbon::now()->subDays(30))->count();
        return response()->json([
            "message"=> $reviews,
            "success" => true
        ]);
        }catch(Exception $err){
            return response()->json([
                "message"=> $err->getMessage(),
                "success" => false
            ]);
        }
    }

    public function getPreviousMonthReviews(){
        try{
            $previousReviews = Review::whereDate("created_at","<=",Carbon::now()->subDays(30))->whereDate("created_at",">",Carbon::now()->subDays(60))->count();
            return response()->json([
                "message"=> $previousReviews,
                "success"=> true
            ]);
        }
        catch(Exception $err){
            return response()->json([
                "message"=> $err->getMessage(),
                "success"=> false
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\addReviewsRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $reviews =  Review::with(['user','product'])->get();
       return ReviewResource::collection($reviews);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(addReviewsRequest $request)
    {
       $review =  Review::create($request->validated());
       $review->load(['user','product']);
       return new ReviewResource($review);
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
       $review->load(['user','product']);
       return new ReviewResource($review);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        // middleware
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // middleware 

    }
}

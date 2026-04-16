<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Images;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::with(['productDetails','images','reviews'])->paginate(10);
        // 
        return ProductResource::collection($data);
        // return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = new Product();
        $product->updateOrCreate([
            'name' => $request->name,
            'stock' => $request->stock,
            'price' => $request->price
        ]);
        $product->save();
        $pro = Product::where('name',$request->name)->get();
        // product details
        $productDetails = new ProductDetail();
        $productDetails->create([
            "product_id" => $pro->id,
            "brand" => $request->brand,
            "category" => $request->category,
            "description" => $request->desc,
        ]);
        $productDetails->save();
        // save the image
        $path = null;
        if($request->hasFile("image")){
            $path = $request->file("image")->store("product_images","public");
        }
        $image = new Images();
        $image->create([
            "img_url" => $path,
            "imageable_id" => $pro->id,
            "imageable_type" => Product::class
        ]);
        $image->save();
        return response()->json([
            "data" => $product,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $product = Product::findOrFail($id)->with(['images','productDetails']);
        return new ProductResource($product);
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

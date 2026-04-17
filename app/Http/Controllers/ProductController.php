<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Images;
use App\Models\Product;
use App\Models\ProductDetail;
use Exception;
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
    public function store(ProductRequest $request)
    {
        $product = Product::create([
            "name" => $request->name,
            "price" => $request->price,
            "stock"=> $request->stock
        ]);
        $product->save();
        $product->productDetails()->create([
            "description" => $request->description,
            "brand" => $request->brand,
            "category" => $request->category,
            "product_id"=> $product->id
        ]);
        
        // images
        $images = [];
        if($request->hasFile('img_url1') && $request->hasFile("img_url2")){
            $images[] = ['img_url' => $request->file("img_url1")->store('product_images','public')];
            $images[] = ['img_url' => $request->file("img_url2")->store('product_images','public')];
        }
        // save img url in database
        $product->images()->createMany($images);

        return new ProductResource($product);
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
    public function update(ProductUpdateRequest $request, string $id)
    {
        try{
            $product = Product::findOrFail($id)->with(['productDetails','images'])->first();
            $product->update([
                "name"=> $request->name,
                "price"=> $request->price,
                "stock" => $request->stock
            ]);
            $product->save();
            // product details
            $proDetails = ProductDetail::where('product_id',$product->id)->first();
            $proDetails->update([
                "description" => $request->description,
                "brand" => $request->brand,
                "category" => $request->category
            ]);
            $proDetails->save();
            // images section
            $img_url1 = null;
            $img_url2 = null;
            if($request->hasFile('image1')){
                $img_url1 = $request->file('image1')->store('product_images','public');
            }
            if($request->hasFile('image2')){
                $img_url1 = $request->file('image2')->store('product_images','public');
            }
            // update images
            $images = Images::where('imageable_type',Product::class)->where('imageable_id',$product->id)->get();
            for($i = 0;count($images)>0;$i++){
                if($i=== 0){
                $images->update([
                    'imageable_id' => $product->id,
                    'img_url' => $img_url1
                ]);
                }else{
                    $images->update([
                        'imageable_id' => $product->id,
                        'img_url' => $img_url2
                    ]);
                }
            }
        }catch(Exception $err){
            return response()->json([
                "success" => false,
                "message" => $err->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

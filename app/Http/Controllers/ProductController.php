<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use \Illuminate\Support\Facades\Storage;
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
    public function index(Request $request)
    {
        $data = Product::with(['productDetails','images','reviews'])->orderBy("created_at","desc")->paginate(4);
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
        try{
            $product = Product::findOrFail($id);
            $product->load(['productDetails','images']);
            return new ProductResource($product);
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
    public function update(Request $request, String $id)
    {
        try{
            $request->validate([
                "name" => "nullable|string|min:3",
                "stock" => "nullable|integer|min:1",
                "price" => "nullable|numeric|min:20",
                "categroy" => "nullable|string|min:3",
                "description" => "nullable|string|min:10",
                "brand" => "nullable|string|min:3",
                "image1" => "nullable|image|mimes:jpg,png,jpeg,gif",
                "image2" => "nullable|image|mimes:jpg,png,jpeg,gif",
            ]);
            $product = Product::findOrFail($id);
            $product->update([
                "name" => $request->name,
                "stock" => $request->stock,
                "price" => $request->price
            ]);

            $product->productDetails()->update([
                "brand" => $request->brand,
                "description" => $request->description,
                "category" => $request->category,
            ]);
            // images path
            $image1 = null;
            $image2 = null;

            if($request->hasFile('image1') && $request->hasFile('image2')){
                $image1 = $request->file("image1")->store('product_images',"public");
                $image2 = $request->file("image2")->store('product_images',"public");
                // delete the previous images
                foreach($product->images as $image){
                    if(Storage::disk('public')->exists($image)){
                        Storage::disk('public')->delete($image);
                    }
                }
                $product->images()->update([
                    ["img_url" => $image1],
                    ["img_url" => $image2]
                ]);
            }

            $product->load(['productDetails','images']);
            return new ProductResource($product);
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
    public function destroy(String $id)
    {
        try{
            $product = Product::findOrFail($id);
            $product->productDetails()->delete();
            foreach($product->images as $image){
                if(Storage::disk('public')->exists($image->img_url)){
                    Storage::disk('public')->delete($image->img_url);
                }
            }
            $product->images()->delete();
            $product->delete();
            return response()->json([
                "Success" => true,
                "message" => "Product with id ".$id." has been deleted successfully"
            ]);
        }
        catch(Exception $err){
            return response()->json([
                "success" => false,
                "message" => $err->getMessage()
            ]);
        }
    }
}

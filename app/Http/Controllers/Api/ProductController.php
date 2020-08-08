<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\OnboardUser;
use App\Http\Resources\ProductResource;
use App\Http\Requests\ProductRequest;
use File;
use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all()->where('authorized','1');
        //return ProductResource::collection($products);
        return $this->sendResponse(ProductResource::Collection($products), 'Products Retrieved');
    }

    
    public function products(){

        $products = Product::all()->where('status', '1');
        return  ProductResource::collection($products);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {   
        $product = new Product;
        $product->user_id = auth()->user()->id; 
       // $product->business_name =  auth()->user()->business_name;
        $product->name = $request->input('name');
        $product->category = $request->input('category');
        $product->unit_price = $request->input('unit_price');
        $product->description = $request->input('description');
        $product->max_unit = $request->input('max_unit');
        $product->min_unit = $request->input('min_unit');
        $product->ref = $request->input('ref');
        $product->quantity = $request->input('quantity');

        if($request->hasFile('img1')){
            $image = $request->file('img1');
            $productImage1 = $product->user_id.'_product_image'. time() .'.' . $image->getClientOriginalExtension();
            Image::make($image)->save(public_path('product_image/'. $productImage1));
            $product->img1 = $productImage1;
        }

        if($request->hasFile('img2')){
            $image = $request->file('img2');
            $productImage2 = $product->user_id.'_product_image'. time() .'.' . $image->getClientOriginalExtension();
            Image::make($image)->save(public_path('product_image/'. $productImage2));
            $product->img2 = $productImage2;
        }

        if($request->hasFile('img3')){
            $image = $request->file('img3');
            $productImage3 = $product->user_id.'_product_image'. time() .'.' . $image->getClientOriginalExtension();
            Image::make($image)->save(public_path('product_image/'. $productImage3));
            $product->img3 = $productImage3;
        }

        //dd($product);
        
        $product->save();
        return $this->sendResponse(new ProductResource($product), 'Product Added');
        //return new ProductResource($product);
        //return $this->sendResponse(new ProductResource($product),'Product Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        if($product->authorized == '1'){
           return new ProductResource($product); 
           
        }else{
            return $this->sendError('Cannot retrieve: Product not authorized');
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrfail($id);
        //dd($product);

        if($product->authorized == 0){
            //sdd('good');
       
        $product->update([

            'name'           => $request->input('name'),
            'category'    => $request->input('category'),
            'unit_price'    => $request->input('unit_price'),
            'description'    => $request->input('description'),
            'max_unit'    => $request->input('max_unit'),
            'max_unit'    => $request->input('max_unit'),
            'quantity'    => $request->input('quantity'),
            ]);

            $oldimg = 'product_image/'.$product->img1;
            if (File::exists($oldimg)) {
                File::delete($oldimg);
            }
            $img1 = $request->file('img1');
            if(!empty($img1)){
                $filename = $product->id.'_product_image'.time().'.'.$img1->getClientOriginalExtension();  
                Image::make($img1)->resize(300, 300)
                    ->save(public_path('product_image/'.$filename));
                $product->img1 = $filename;
    
                $product->update([
                    'img1'   => $filename,
                ]);
                }

                $oldimg2 = 'product_image/'.$product->img2;
                if (File::exists($oldimg2)) {
                    File::delete($oldimg2);
                }
                $img2 = $request->file('img2');
                if(!empty($img2)){
                    $filename = $product->id.'_product_image'.time().'.'.$img2->getClientOriginalExtension();  
                    Image::make($img2)->resize(300, 300)
                        ->save(public_path('product_image/'.$filename));
                    $product->img2 = $filename;
        
                    $product->update([
                        'img2'   => $filename,
                    ]);
                    }

                    $oldimg3 = 'product_image/'.$product->img3;
                    if (File::exists($oldimg3)) {
                        File::delete($oldimg3);
                    }
                    $img3 = $request->file('img3');
                    if(!empty($img3)){
                        $filename = $product->id.'_product_image'.time().'.'.$img3->getClientOriginalExtension();  
                        Image::make($img3)->resize(300, 300)
                            ->save(public_path('product_image/'.$filename));
                        $product->img3 = $filename;
            
                        $product->update([
                            'img3'   => $filename,
                        ]);
                        
                        }
        //return new ProductResource($product);
        return $this->sendResponse(new ProductResource($product), 'Product updated');
            }else{
                return $this->sendError('Cannot update: Product already authorized');
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if($product->authorized == '0'){

            
            $img1 = 'product_image/'.$product->img1;
                    if (File::exists($img1)) {
                        File::delete($img1);
                    }

            $img2 = 'product_image/'.$product->img2;
                if (File::exists($img2)) {
                    File::delete($img2);
                }

            $img3 = 'product_image/'.$product->img3;
                if (File::exists($img3)) {
                    File::delete($img3);
                }
            $product->delete();

            //return new ProductResource($product);
            return $this->sendResponse(new ProductResource($product), 'Product Deleted');
        }else{
            return $this->sendError('Cannot delete: Product already authorized');
        }
        
    }

    public function userProduct(){
        $user = auth()->user();
        $products = Product::where('user_id', $user->id)->where('status', TRUE)->get();
        if ($products->isEmpty()) {
            return parent::respondOk('You have no products yet.'); 
        }
        return  ProductResource::collection($products);

    }
}

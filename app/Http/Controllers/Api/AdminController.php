<?php

namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Http\Resources\User as UserResource;
use App\Http\Requests\OnboardUserRequest;
use App\Http\Resources\ProductResource;
use App\Http\Requests\ProductRequest;
use App\Http\Controllers\Api\ApiController;
use App\Models\Product;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;

class AdminController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        return new UserResource($user);
    }

    public function users()
    {
        $users =  User::all();
        //dd($users);
        //return UserResource::collection($users);
        return $this->sendResponse(UserResource::collection($users), 'Users Retreieved');
    }


    public function getProduct(){
        $products = Product::all();
        //return ProductResource::collection($products); 
        return $this->sendResponse(ProductResource::collection($products), 'Products Retrieved');
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
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $user = User::findOrFail($id);        
        $user->update([
            'status'           => $request->input('status'),
            'isAdmin'    => $request->input('isAdmin'),
            'isAgent'    => $request->input('isAgent')
            ]);
        // dd($user);
        return new UserResource($user);
        return $this->sendResponse(new UserResource($user), 'User authorized');
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrfail($id);
        $product->update([
            'status'           => $request->input('status'),
            'authorized'    => $request->input('authorized')
            ]);
        //dd($product);
        //return new ProductResource($product);
        return $this->sendResponse(new ProductResource($product), 'Product Authorized');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use File;
use Intervention\Image\ImageManagerStatic as Image;

class TransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $transactions = Transaction::all();
        return TransactionResource::collection($transactions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        if(auth()->user()->status == 0){
            return "Sorry! Unverified users can't make purchase.";
        }
        $transaction = new Transaction;
        $transaction->user_id =  auth()->user()->id;
        $transaction->product_id = $request->input('product_id');
        $transaction->purchased_unit = $request->input('purchased_unit');
        $transaction->amount = $request->input('amount');
        $transaction->paystack_ref = $request->input('paystack_ref');

            if($request->hasFile('receipt_upload')){
                $image = $request->file('receipt_upload');
                $productImage1 = $transaction->user_id.'_receipt_image'. time() .'.' . $image->getClientOriginalExtension();
                Image::make($image)->save(public_path('receipt_image/'. $productImage1));
                $transaction->receipt_upload = $productImage1;
            }


        $transaction->save();
        //dd($transaction);
        return $this->sendResponse(new TransactionResource($transaction), 'Transaction Created');
        //return new TransactionResource($transaction);
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
        $transaction = Transaction::findOrFail($id);  
            
        $transaction->update([
            'status'       => $request->input('status'),
            'completed'    => $request->input('completed')
            ]);
        // dd($user);
        return $this->sendResponse(new TransactionResource($transaction), 'Transaction Authorised');
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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\Subscription;
use App\Models\User;
use App\Models\OnboardUser;
use App\Http\Resources\SubscriptionResource;
use App\Http\Requests\SubscriptionRequest;
use File;
use Intervention\Image\ImageManagerStatic as Image;

class SubscriptionController extends ApiController
{
    public function index()
    {
        $subscription = Subscription::all()->where('authorized','1');
        return $this->sendResponse(SubscriptionResource::Collection($subscription), 'Subscription Retrieved');
    }

    public function show($id)
    {
        $subscription = Subscription::findOrFail($id);
        if($subscription->authorized == '1'){
           return new SubscriptionResource($subscription); 
           
        }else{
            return $this->sendError('Sorry bros try go subscribe, Nonsense!');
        }
    }

    public function store(SubscriptionRequest $request)
    {
        $subscription = new Subscription;
        $subscription->user_id = auth()->user()->id;
        $subscription->sub_type = $request->input('sub_type');
        $subscription->amount = $request->input('amount');
        $subscription->status = $request->input('status');
        $subscription->paystack_ref = $request->input('paystack_ref');

        if($request->hasFile('receipt_image')){
            $image = $request->file('receipt_image');
            $receipt_image = $subscription->user_id.'_subcription_image'. time() .'.' . $image->getClientOriginalExtension();
            Image::make($image)->save(public_path('subscription_image/'. $receipt_image));
            $subscription->receipt_image = $receipt_image;
        }

        $subscription->authorized = $request->input('authorized');

        $subscription->save();
        return $this->sendResponse(new SubscriptionResource($subscription), 'Subscription added!');
    }

    public function update(Request $request, $id)
    {
        $subscription = Subscription::findOrFail($id);  
            
        $subscription->update([
            'status'       => $request->input('status'),
            'authorized'    => $request->input('authorized')
            ]);
        // dd($user);
        return $this->sendResponse(new SubscriptionResource($subscription), 'Subscription Authorised');
    }
}

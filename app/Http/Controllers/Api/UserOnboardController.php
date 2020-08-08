<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\OnboardUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OnboardUser;
use App\Http\Resources\User as UserResource;
use File;
use Intervention\Image\ImageManagerStatic as Image;
class UserOnboardController extends ApiController
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
    public function update(OnboardUserRequest $request)
    {   //sdd('user');
       
        $user = auth()->user();
        $user->update([
        'gender'            => $request['gender'],
        'phone'             => $request->input('phone'),
        'phone_2'           => $request->input('phone_2'),
        'address'           => $request->input('address'),
        'nearest_bustop'    => $request->input('nearest_bustop'),
        'delivery_bus_park' => $request->input('delivery_bus_park'),
        'business_name'     => $request->input('business_name'),
        ]);
        //dd($user);
        $oldimg = 'profile_image/'.$user->image;
        if (File::exists($oldimg)) {
            File::delete($oldimg);
        }
        $image = $request->file('image');
        if(!empty($image)){
            $filename = $user->id.'_profile_image'.time().'.'.$image->getClientOriginalExtension();  
            Image::make($image)->resize(300, 300)
                ->save(public_path('profile_image/'.$filename));
            $user->image = $filename;

            $user->update([
                'image'   => $filename,
            ]);
            
            }

        $user->update([
                'first_name'  => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
            ]);
        
       //return new UserResource($user);
       return $this->sendResponse(new UserResource($user), 'User updated');
        
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
    // public function update(Request $request, $id)
    // {
    //     //
    // }

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

    public function user(Request $request){
        $user = auth()->user();
        return response()->json($user);
    }
}


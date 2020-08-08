<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use App\Mail\VerifyYourEmail;
use App\Http\Traits\IssueTokenTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Api\ApiController;

class RegisterController extends ApiController
{
    use IssueTokenTrait;

    private $client;

    public function __construct()
    {
        $this->client = Client::where('password_client', 1)->first();
    }

    /**
     * Register a user for the application.
     *
     * @param Request $request
     *
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'category' => ['required', 'string'],
            // 'gender' => ['required', 'string'],
            // 'phone' => ['required', 'string'],
            'email'    => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        do {
            $token = mt_rand(100000, 999999);
        } while (User::where('api_verification_code', $token)->exists());

        $user = User::create([
            'first_name'              => $request->input('first_name'),
            'last_name'              => $request->input('last_name'),
            'category'              => $request->input('category'),
            // 'gender'              => $request->input('gender'),
            // 'phone'              => $request->input('phone'),
            'email'                 => $request->input('email'),
            'password'              => Hash::make($request->input('password')),
            'api_verification_code' => $token,
        ]);

        Mail::to($user)->send(new VerifyYourEmail($user));

        $response = $this->issueToken($request);

        return $this->respondCreated(json_decode($response->getContent(), true));
    }
}

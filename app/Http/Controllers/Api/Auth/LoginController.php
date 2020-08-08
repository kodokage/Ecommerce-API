<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\IssueTokenTrait;
use App\Http\Controllers\Api\ApiController;
use App\Models\User;

class LoginController extends ApiController
{
    use IssueTokenTrait;
    private $client;

    public function __construct()
    {
        $this->client = Client::where('password_client', 1)->first();
    }

    /**
     * Log the user in to the application.
     *
     * @param Request $request
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $response = $this->issueToken($request);

        if ($response->getStatusCode() !== 200) {
            return $this->respondTokenError(json_decode($response->getContent(), true));
        }

        return $this->respondCreated(json_decode($response->getContent(), true));
    }

    public function socialAuth(Request $request){
        $this->validate($request, [
            'social_id' => ['required'],
            'email'    => ['required', 'string', 'email'],
            'category' => ['string', "in:buyer,seller"],
        ]);
        $social_id = $request->social_id;
        $email = $request->email;
        $category = $request->category;

        $get_user = User::where('social_id', $social_id)->orWhere('email', $email)->first();
        
        if (!$get_user && $category ) {
            $get_user = new User();
            $get_user->social_id = $social_id;
            $get_user->category = $category;
            $get_user->email = $email;
            $get_user->password = bcrypt('12345678');
            $get_user->save();
        }

        return response()->json(["data" => [
            "token_type" => "Bearer",
            'access_token' => $get_user->createToken('API Token')->accessToken,
        ]]);
    }

    /**
     * Refresh the user's access token.
     *
     * @param Request $request
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request)
    {
        $this->validate($request, [
            'refresh_token'=> 'required',
        ]);

        $response = $this->refreshToken($request);

        if ($response->getStatusCode() !== 200) {
            return $this->respondTokenError(json_decode($response->getContent(), true));
        }

        return $this->respondCreated(json_decode($response->getContent(), true));
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', auth()->user()->token()->id)
            ->update(['revoked' => true]);

        auth()->user()->token()->revoke();

        return $this->setStatusCode(204)->respond([]);
    }
}

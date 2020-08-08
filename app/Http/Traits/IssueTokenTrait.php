<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

trait IssueTokenTrait
{
    /**
     * Request an access token from the OAuth server.
     *
     * @param Request $request
     * @param string  $grantType
     * @param string  $scope
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function issueToken(Request $request, $grantType = 'password', $scope = '*')
    {
        $request->request->add([
            'grant_type'    => $grantType,
            'client_id'     => $this->client->id,
            'client_secret' => $this->client->secret,
            'username'      => $request->input('email'),
            'password'      => $request->input('password'),
            'scope'         => $scope,
        ]);

        return Route::dispatch(Request::create('oauth/token', 'POST'));
    }

    /**
     * Request for a fresh access token from OAuth server
     * after the expiration of current access token.
     *
     * @param Request $request
     * @param string  $grantType
     * @param string  $scope
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function refreshToken(Request $request, $grantType = 'refresh_token', $scope = '*')
    {
        $request->request->add([
            'grant_type'    => $grantType,
            'refresh_token' => $request->input('refresh_token'),
            'client_id'     => $this->client->id,
            'client_secret' => $this->client->secret,
            'scope'         => $scope,
        ]);

        return Route::dispatch(Request::create('oauth/token', 'POST'));
    }
}

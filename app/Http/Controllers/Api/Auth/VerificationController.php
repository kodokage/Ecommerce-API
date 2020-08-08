<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Auth\Access\AuthorizationException;

class VerificationController extends ApiController
{
    /**
     * Verify a user using a token.
     *
     * @param Request $request
     *
     * @throws AuthorizationException
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {
        $validatedData = $request->validate([
            'token' => ['required', 'exists:users,api_verification_code'],
        ]);

        $user = User::whereApiVerificationCode($validatedData['token'])->first();
        if ($user->hasVerifiedEmail()) {
            throw new AuthorizationException();
        }
        $user->markEmailAsVerified();

        return $this->respondOk('E-mail verification successful', 'Verified');
    }
}

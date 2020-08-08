<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Mail\PasswordResetEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Api\ApiController;

class ForgotPasswordController extends ApiController
{
    private $databaseTable;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->databaseTable = DB::table('password_resets');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::whereEmail($request->input('email'))->first();

        if (!$user) {
            return $this->respondNotFound('User with specified e-mail not found');
        }

        $token = $this->createNewToken();
        $this->databaseTable->insert([
            'email'      => $user->email,
            'token'      => $token,
            'created_at' => new Carbon(),
        ]);
        Mail::to($user)->send(new PasswordResetEmail($token));

        return $this->respondOk('Password reset e-mail sent', 'Notification sent');
    }

    /**
     * @return int
     */
    protected function createNewToken(): int
    {
        do {
            $token = mt_rand(100000, 999999);
        } while ($this->databaseTable->where('token', $token)->exists());

        return $token;
    }
}

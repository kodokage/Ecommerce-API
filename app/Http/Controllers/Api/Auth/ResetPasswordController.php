<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\ApiController;

class ResetPasswordController extends ApiController
{
    private $table;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->table = DB::table('password_resets');
    }

    /**
     * Reset the user's password using the token supplied.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token'    => ['required'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $record = $this->table->where('token', $request->input('token'))->first();

        if (!$record) {
            return $this->respondNotFound('Invalid password reset token');
        }

        $user = User::whereEmail($record->email)->firstOrFail();

        if ($this->tokenExpired($record)) {
            $this->deleteExistingTokens($user);

            return $this->respondUnprocessed('Expired password reset token');
        }

        $user->update(['password' => Hash::make($request->input('password'))]);
        $this->deleteExistingTokens($user);

        return $this->respondOk('Password reset successful');
    }

    /**
     * Determine if the token has expired.
     *
     * @param $record
     *
     * @return bool
     */
    protected function tokenExpired($record): bool
    {
        return Carbon::parse($record->created_at)->addMinutes(config('auth.passwords.users.expire'))->isPast();
    }

    /**
     * Delete all existing reset tokens belonging to this user from the database.
     *
     * @param User $user
     */
    protected function deleteExistingTokens(User $user): void
    {
        $this->table->where('email', $user->email)->delete();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;

class AdminCustomerRegistrationController extends Controller
{
    public function index(Request $request, string $token)
    {
        try {
            $decryptToken = Crypt::decryptString($token);
            $email = $request->string('email')->trim();

            $user = User::where('register_token', $decryptToken)
                ->where('email', $email)
                ->where('active', false)
                ->where('type', 2)
                ->whereNull('last_login_at')
                ->firstOrFail();

            return view('guest.customer.register', ['token' => $token, 'user' => $user]);
        } catch (\Throwable $th) {
            return Redirect::route('register', urlencode($token) . '?email=' . urlencode($email));
        }
    }
}

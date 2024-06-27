<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            if (optional(Auth::user())->isAdmin()) {
                return redirect()->intended(route('admin.dashboard', absolute: false).'?verified=1');
            } else {
                return redirect()->intended(route('app.dashboard', absolute: false).'?verified=1');
            }
           
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        if (optional(Auth::user())->isAdmin()) {
            return redirect()->intended(route('admin.dashboard', absolute: false).'?verified=1');
        } else {
            return redirect()->intended(route('app.dashboard', absolute: false).'?verified=1');
        }
    }
}

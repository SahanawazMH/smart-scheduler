<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        $userRole = $request->user()->role;

        return $request->user()->hasVerifiedEmail()
                    ? redirect("/{$userRole}/dashboard")
                    : view('auth.verify-email');
    }
}

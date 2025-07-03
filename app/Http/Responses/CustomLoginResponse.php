<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class CustomLoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request): RedirectResponse|JsonResponse
    {
        // Check if the authenticated user is an admin.
        if (auth()->user()->role !== 'admin') {
            Auth::logout();

            return redirect()->route('login')->withErrors(['email' => 'You are not allowed to access the admin page.']);
        }

        // If the user is an admin, proceed to the intended dashboard.
        return $request->wantsJson()
                    ? new JsonResponse('', 204)
                    : redirect()->intended(config('fortify.home'));
    }
}
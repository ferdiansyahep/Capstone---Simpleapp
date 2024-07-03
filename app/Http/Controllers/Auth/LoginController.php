<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Override the credentials method to accept either email or nomer_induk
    public function credentials(Request $request)
    {
        $field = filter_var($request->get($this->username()), FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'nomer_induk';

        return [
            $field => $request->get($this->username()),
            'password' => $request->password,
        ];
    }

    // Override the attemptLogin method to handle the login attempt
    protected function attemptLogin(Request $request)
    {
        return Auth::attempt($this->credentials($request), $request->filled('remember'));
    }
}

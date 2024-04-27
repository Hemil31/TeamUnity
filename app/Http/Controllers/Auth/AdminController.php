<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthValidation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Auth;

class AdminController extends Controller
{
    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin');
    }


    /**
     * Summary of login
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function login(AuthValidation $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/dashboard');
        }

        return redirect()->back()->withInput()->withErrors(['loginError' => 'Invalid email or password.']);
    }

    /**
     * Summary of logout
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(): RedirectResponse{
        Auth::logout();
        return redirect('/login');
    }

}

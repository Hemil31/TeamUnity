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
        // Get the email and password from the request
        $credentials = $request->only('email', 'password');
        // Check if the user is authenticated
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/dashboard');
        }
        // Redirect back with error message
        return redirect()->back()->withInput()->withErrors(['loginError' => 'Invalid email or password.']);
    }

    /**
     * Summary of logout
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        // Logout the user
        Auth::logout();
        // Redirect to login page
        return redirect('/login');
    }

}

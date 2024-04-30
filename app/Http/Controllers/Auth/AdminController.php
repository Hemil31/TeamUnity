<?php

namespace App\Http\Controllers\Auth; // Fixed the namespace to 'Auth' instead of 'auth'

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthValidation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Imported Auth facade

class AdminController extends Controller
{
    /**
     * Display the admin panel.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin');
    }


    /**
     * Handle the authentication process.
     *
     * @param  AuthValidation  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(AuthValidation $request): RedirectResponse
    {
        try {
            // Attempt to retrieve email and password from the request
            $credentials = $request->only('email', 'password');

            // Try to authenticate the user
            if (Auth::attempt($credentials)) {
                return redirect()->intended('/dashboard'); // Redirect to intended URL after successful login
            } else {
                // Redirect back with error message if authentication fails
                return redirect()->back()->withInput()->withErrors(['error' => 'Invalid email or password.']);
            }
        } catch (\Exception $e) {
            // Catch any exceptions that might occur during authentication
            // Log the exception for debugging if necessary
            // Redirect back with a generic error message
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred during login. Please try again.']);
        }
    }

    /**
     * Handle the logout process.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        try {
            // Attempt to logout the user
            Auth::logout();
            // Redirect to the login page after logout
            return redirect('/login');
        } catch (\Exception $e) {
            // Catch any exceptions that might occur during logout
            // Log the exception for debugging if necessary
            // Redirect to the login page with a generic error message
            return redirect('/login')->withErrors(['error' => 'An error occurred during logout. Please try again.']);
        }
    }

}

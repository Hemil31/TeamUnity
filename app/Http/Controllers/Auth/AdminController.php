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
     * Display the admin panel login page.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin');
    }


    /**
     * Handle the authentication process.
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
                return redirect()->intended('/')->with('success', 'You have successfully logged in.');
            } else {
                // Redirect back with error message if authentication fails
                return redirect()->back()->withInput()->with('success', 'Invalid email or password.');
            }
        } catch (\Exception $e) {
            // Catch any exceptions that might occur during authentication
            return redirect()->back()->with('error', 'An error occurred during login. Please try again.' . $e->getMessage());
        }
    }

    /**
     * Handle the logout process.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        try {
            // Attempt to logout the user
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            // Redirect to the login page after logout
            return redirect('/login')->with('success', 'You have successfully logged out.');
        } catch (\Exception $e) {
            // Catch any exceptions that might occur during logout
            return redirect()->back()->with('error', 'An error occurred during logout. Please try again.' . $e->getMessage());
        }
    }
}

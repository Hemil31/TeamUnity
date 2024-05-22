<?php

namespace App\Http\Controllers\Auth; // Fixed the namespace to 'Auth' instead of 'auth'

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthValidation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Imported Auth facade


/**
 * AdminController class is responsible for handling
 * The admin panel login and logout process.
 */
class AdminController extends Controller
{
    /**
     * Display the admin panel login page.
     * @return\Illuminate\Contracts\View\View
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
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                return redirect()->intended('/')->with('success', 'You have successfully logged in.');
            } else {
                return redirect()->back()->withInput()->with('success', 'Invalid email or password.');
            }
        } catch (\Exception $e) {
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
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/login')->with('success', 'You have successfully logged out.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred during logout. Please try again.' . $e->getMessage());
        }
    }
}

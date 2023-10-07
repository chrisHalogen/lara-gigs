<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //Create Users
    public function create()
    {
        return view('users.register');
    }

    // Store the new user
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6',
        ]);

        // Hash Password
        $formFields['password'] = bcrypt($formFields['password']);

        $user = User::create($formFields);

        auth()->login($user);

        return redirect('/')->with('message', 'User created and Logged In');
    }

    //Create Users
    public function logout(Request $request)
    {
        auth()->logout();

        // While logging the user out, It is very important to invalidate the current user session
        $request->session()->invalidate();

        // Also regenerate token
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'User Logged Out');
    }

    //Create Users
    public function login()
    {
        return view('users.login');
    }

    //Create Users
    public function authenticate(Request $request)
    {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required|min:6',
        ]);

        if (auth()->attempt($formFields)) {
            $request->session()->regenerate();
            return redirect('/')->with('message', 'You are now Logged in!!!');
        }

        return back()->withErrors(['email' => 'Invalid Cridentials']);
    }

    // Relationship to user
    public function listing()
    {
        // Check eloquent's documentation for more info
        return $this->hasMany(Listing::class, 'user_id');
    }
}

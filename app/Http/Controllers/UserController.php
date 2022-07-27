<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Show Register/Create Form
    public function create(){
        return view("users.register");
    }

    // Create new user
    public function store(Request $request){
        $formFields = $request->validate([
            "name" => ["required", "min:3"],
            "email" => ["required", "email", Rule::unique("users", "email")],
            "password" => ["required", "confirmed", "min:6"] // Confirmed will make sure it equals the confimation input that is in the form (Stick to the naming convention in the html tag to make this work)
        ]);

        // Hash Password
        $formFields["password"] = bcrypt($formFields["password"]);

        // Create User
        $user = User::create($formFields);

        // Login
        auth()->login($user);

        return redirect("/")->with("message", "User created and logged in");
    }

    // Logout User
    public function logout(Request $request){
        auth()->logout(); // This will remove the auth from the session
        // It's recommeneded to do this, to be secure
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect("/")->with("message", "You have been logged out!");
    }

    // Show Login Form
    public function login(){
        return view("users.login");
    }

    // Authenticate User
    public function authenticate(Request $request){
        $formFields = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"]
        ]);

        if(auth()->attempt($formFields)){
            $request->session()->regenerate();
            return redirect("/")->with("message", "You are now Logged in");
        }
        
        return back()->withErrors(["email" => "Invalid Email or Password"])->onlyInput("email");
    }
}

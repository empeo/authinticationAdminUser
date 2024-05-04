<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index(){
        return view('welcome');
    }
    public function login()
    {
        return view('auth.login');
    }
    public function ensurelogin(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"]
        ]);
        if (!$user) {
            return redirect()->back()->with("error", "Invalid User")->withInput($request->only("email"));
        }
        $credentials = $request->only("email", "password");
        if ($user->role == 'admin') {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route("admin.dashboard");
            }
        } else {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route("user.home");
            }
        }
        return redirect()->back()->with("error", "Invalid User")->withInput($credentials);
    }
    public function register()
    {
        return view('auth.signup');
    }
    public function ensureregister(Request $request)
    {
        $request->validate([
            "name" => ["required"],
            "email" => ["required", "email", "unique:users,email"],
            "password" => ["required", "regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+{};:,<.>])[A-Za-z\d!@#$%^&*()\-_=+{};:,<.>]{5,}$/"],
            "conipassword" => ["required", "same:password"],
            "phone" => ["required", "regex:/^[0-9]{11}$/"],
            "gender" => ["required", "in:male,female"],
            "image" => ["required", "mimes:jpg,png,jpeg", "max:1024"],
        ]);
        $requestDB = $request->only(['name', 'email', 'password', 'phone', 'gender', 'image']);
        $requestDB["password"] = Hash::make($request->password);
        $image = $request->file("image");
        $imageName = time() . "." . $image->getClientOriginalExtension();
        $image->move(public_path("assets/users/user/"), $imageName);
        $requestDB["image"] = $imageName;
        $user = User::create($requestDB);
        if ($user) {
            return redirect()->route("login")->with("success", "User Created Successfully");
        }
        return redirect()->back()->with("error", "User Not Created")->withInput($requestDB);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        return redirect()->route("login");
    }
}

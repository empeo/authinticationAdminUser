<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
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
    public function ensurelogin(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user){
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
    public function ensureregister(RegisterRequest $request)
    {
        $requestDB = $request->validated();
        $requestDB["password"] = Hash::make($request->password);
        $image = $request->file("image");
        $imageName = time() . "." . $image->getClientOriginalExtension();
        $image->move(public_path("assets/users/user/"), $imageName);
        $requestDB["image"] = $imageName;
        $user = User::create($requestDB);
        if ($user) {
            Auth::loginUsingId($user->id);
            return redirect()->intended(RouteServiceProvider::HOMEClient)->with('success', 'User created and logged in successfully');
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

<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function home()
    {
        $users = User::all();
        $posts = Post::paginate(4);
        return view("home", ["users" => $users, "posts" => $posts]);
    }
    public function profile()
    {
        $users = User::find(auth()->user()->id);
        return view("user.profile", ["user" => $users]);
    }
    public function edit(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with("error", "User not found");
        }
        return view("user.users.edit", ["user" => $user]);
    }
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $request->validate([
            "name" => ["required"],
            "email" => ["required", "email", "unique:users,email," . $id],
            "password" => ["nullable", "regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+{};:,<.>])[A-Za-z\d!@#$%^&*()\-_=+{};:,<.>]{5,}$/"],
            "conipassword" => ["nullable", "same:password"],
            "phone" => ["required", "regex:/^[0-9]{11}$/"],
            "gender" => ["required", "in:male,female"],
            "image" => ["mimes:jpg,png,jpeg", "max:1024"],
        ]);
        $requestDB = $request->only(['name', 'email', 'phone', 'gender', 'image']);
        if ($request->filled('password')) {
            $requestDB["password"] = Hash::make($request->password);
        }
        if ($request->hasFile("image")) {
            if ($user->image) {
                unlink(public_path("assets/users/user/" . $user->image));
            }
            $image = $request->file("image");
            $imageName = time() . "." . $image->getClientOriginalExtension();
            $image->move(public_path("assets/users/user/"), $imageName);
            $requestDB["image"] = $imageName;
        }
        $result = $user->update($requestDB);
        if ($result) {
            return redirect()->route("user.profile")->with("success", "User updated successfully");
        }
        return redirect()->back()->with("error", "User not updated");
    }
    public function destroy(Request $request, string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with("error", "User not found");
        }
        if ($user->image) {
            unlink(public_path("assets/users/user/" . $user->image));
        }
        $user->delete();
        Auth::logout();
        $request->session()->flush();
        return redirect()->route("login")->with("success", "User deleted successfully");
    }
}
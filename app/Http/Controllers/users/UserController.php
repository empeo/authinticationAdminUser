<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function home()
    {
        $users = User::with("posts")->paginate(4);
        return view("home", ["users" => $users]);
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
    public function update(UserUpdateRequest $request, string $id)
    {
        $user = User::find($id);
        $requestDB = $request->validated();
        if ($request->filled('password')) {
            $requestDB["password"] = Hash::make($request->password);
        }else{
            unset($requestDB["password"]);
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

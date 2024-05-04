<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function home(){
        $users = User::all();
        $posts = Post::paginate(4);
        return view("home", ["users" => $users, "posts" => $posts]);
    }
    public function index(){
        $users = User::where("role","user")->paginate(10);
        return view('admin.users.index',["users"=>$users]);
    }
    public function create(){
        return view('admin.users.create');
    }
    public function store(Request $request){
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
            return redirect()->route("users.index")->with("success", "User Created Successfully");
        }
        return redirect()->back()->with("error", "User Not Created")->withInput($requestDB);

    }
    public function show(string $id){
        $user = User::find($id);
        if(!$user){
            return redirect()->route('users.index')->with('error','User not found');
        }
        return view("admin.users.show",["user"=>$user]);
    }
    public function edit(string $id){
        $user = User::find($id);
        if(!$user){
            return redirect()->route("users.index")->with("error","User Not Found");
        }
        return view("admin.users.edit",["user"=>$user]);
    }
    public function update(Request $request , string $id){
        $user = User::find($id);
        $request->validate([
            "name" => ["required"],
            "email" => ["required", "email", "unique:users,email," . $user->id, "regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/"],
            "password" => ["nullable", "regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+{};:,<.>])[A-Za-z\d!@#$%^&*()\-_=+{};:,<.>]{5,}$/"],
            "conipassword" => ["nullable", "same:password"],
            "phone" => ["required", "regex:/^[0-9]{11}$/"],
            "gender" => ["required", "in:male,female"],
            "image" => ["mimes:jpg,png,jpeg", "max:1024"],
        ]);
        $requestDB = $request->only(['name', 'email', 'phone', 'gender']);
        if ($request->filled('password')) {
            $requestDB["password"] = Hash::make($request->password);
        }
        if ($request->hasFile("image")) {
            if($user->role == "admin"){
                if ($user->image) {
                    unlink(public_path("assets/adminImages/profile/" . $user->image));
                }
                $image = $request->file("image");
                $imageName = time() . "." . $image->getClientOriginalExtension();
                $image->move(public_path("assets/adminImages/profile/"), $imageName);
                $requestDB["image"] = $imageName;
            }else{
                if ($user->image) {
                    unlink(public_path("assets/users/user/" . $user->image));
                }
                $image = $request->file("image");
                $imageName = time() . "." . $image->getClientOriginalExtension();
                $image->move(public_path("assets/users/user/"), $imageName);
                $requestDB["image"] = $imageName;
            }
        }
        $result = $user->update($requestDB);
        if ($result) {
            if ($user->id === auth()->user()->id) {
                return redirect()->route("admin.profile")->with("success", "User updated successfully");
            } else {
                return redirect()->route("users.show",$user->id)->with("success", "User updated successfully");
            }
        }
        return redirect()->back()->with("error", "User not updated");
    }
    public function destroy(Request $request,string $id){
        $user = User::find($id);
        if(!$user){
            return redirect()->route('users.index')->with('error','User not found');
        }
        if($user->role == "admin"){
            if($user->image){
                unlink(public_path("assets/adminImages/profile/".$user->image));
            }
        }
        else{
            if($user->image){
                unlink(public_path("assets/users/user/".$user->image));
            }
        }
        $user->delete();
        Auth::logout();
        $request->session()->flush();
        return redirect()->route('login');
    }
    public function deleteuser(string $id){
        $user = User::find($id);
        if($user->image){
            unlink(public_path("assets/users/user/".$user->image));
        }
        $user->delete();
        return redirect()->route('users.index')->with('success','User deleted successfully');
    }
    public function profile(){
        $user = User::find(auth()->user()->id);
        return view('admin.profile', ["user"=>$user]);
    }
    public function dashboard(){
        return view('admin.dashboard');
    }
    public function clear(){
        $users = User::where("role","user")->pluck("image")->toArray();
        function deleteImages(string $path,array $images){
            foreach($images as $image){
                if(public_path($path.$image)){
                    unlink(public_path($path.$image));
                }
            }
        }
        deleteImages("assets/users/user/",$users);
        User::where("role","user")->delete();
        return redirect()->route('users.index')->with('success','All users deleted successfully');
    }
}
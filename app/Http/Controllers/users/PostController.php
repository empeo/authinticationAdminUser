<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where("user_id", auth()->user()->id)->get();
        return view("user.posts.index", ["posts" => $posts]);
    }
    public function create()
    {
        return view('user.posts.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            "title" => ["required", "min:3", "max:20"],
            "description" => ["required", "min:20"],
            "image" => ["required", "mimes:jpg,png,jpeg", "max:1024"],
        ]);
        $requestDB = $request->only(['title', 'description', 'image']);
        $image = $request->file("image");
        $imageName = time() . "." . $image->getClientOriginalExtension();
        $requestDB["image"] = $imageName;
        $image->move(public_path("assets/posts/"), $imageName);
        $requestDB["user_id"] = auth()->user()->id;
        $result = Post::create($requestDB);
        if ($result) {
            return redirect()->route("post.index");
        }
        return redirect()->back()->with("error", "SomeThing Wrong")->withInput($requestDB);
    }
    public function edit(string $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return redirect()->route("post.index");
        }
        return view("user.posts.edit", ["post" => $post]);
    }
    public function show(string $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return redirect()->route("post.index");
        }
        return view("user.posts.show", ["post" => $post]);
    }
    public function update(Request $request, string $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return redirect()->route("post.index");
        }
        $request->validate([
            "title" => ["required", "min:3", "max:20"],
            "description" => ["nullable", "min:20"],
            "image" => ["mimes:jpg,png,jpeg", "max:1024"],
        ]);
        $requestDB = $request->only(['title']);
        if ($request->filled("description")) {
            $requestDB["description"] = $request->description;
        }
        if ($request->hasFile("image")) {
            if ($post->image) {
                unlink(public_path("assets/posts/" . $post->image));
            }
            $image = $request->file("image");
            $imageName = time() . "." . $image->getClientOriginalExtension();
            $image->move(public_path("assets/posts/"), $imageName);
            $requestDB["image"] = $imageName;
        }
        $result = $post->update($requestDB);
        if ($result) {
            return redirect()->route("post.show", $id)->with("success", "User updated successfully");
        }
        return redirect()->back()->with("error", "User not updated");
    }
    public function destroy(string $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return redirect()->route("post.index");
        }
        if ($post->image) {
            unlink(public_path("assets/posts/" . $post->image));
        }
        $post->delete();
        return redirect()->route("post.index")->with("success", "Post deleted successfully");
    }
}

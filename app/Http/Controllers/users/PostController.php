<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Models\Post;

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
    public function store(PostStoreRequest $request)
    {
        $requestDB = $request->validated();
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
    public function update(PostUpdateRequest $request, string $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return redirect()->route("post.index");
        }
        $requestDB = $request->validated();
        if ($request->filled("description")) {
            $requestDB["description"] = $request->description;
        }else{
            unset($requestDB['description']);
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

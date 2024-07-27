<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Models\Post;
use App\Models\User;

class AdminPostController extends Controller
{
    public function index()
    {
        $users = User::where("role","user")->with("posts")->paginate(4);
        return view('admin.posts.index',["users"=>$users]);
    }
    public function create(){
        return view("admin.posts.create");
    }
    public function store(PostStoreRequest $request){
        $requestDB = $request->validated();
        $image = $request->file("image");
        $imageName = time() . "." . $image->getClientOriginalExtension();
        $requestDB["image"] = $imageName;
        $image->move(public_path("assets/posts/"), $imageName);
        $requestDB["user_id"] = auth()->user()->id;
        $result = Post::create($requestDB);
        if ($result) {
            return redirect()->route("posts.index");
        }
        return redirect()->back()->with("error", "SomeThing Wrong")->withInput($requestDB);
    }
    public function show(string $id){
        $post = Post::find($id);
        if (!$post) {
            return redirect()->route("posts.index");
        }
        return view("admin.posts.show", ["post" => $post]);
    }
    public function edit(string $id){
        $post = Post::find($id);
        if (!$post) {
            return redirect()->route("posts.index");
        }
        return view("admin.posts.edit", ["post" => $post]);
    }
    public function update(PostUpdateRequest $request, string $id){
        $post = Post::find($id);
        if (!$post) {
            return redirect()->route("posts.index");
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
            return redirect()->route("posts.show", $id)->with("success", "User updated successfully");
        }
        return redirect()->back()->with("error", "User not updated");
    }
    public function destroy(string $id){
        $post = Post::find($id);
        if($post->image){
            unlink(public_path("assets/posts/".$post->image));
        }
        $post->delete();
        return redirect()->route("posts.index")->with("success", "Post deleted successfully");
    }
    public function clear(){
        $postid = User::where("role","user")->pluck("id");
        $postsImages = Post::whereIn("user_id",$postid)->pluck("image")->toArray();
        function deleteImages(string $path,array $images){
            foreach($images as $image){
                if(file_exists(public_path($path.$image))){
                    unlink(public_path($path.$image));
                }
            }
        }
        deleteImages("assets/posts/",$postsImages);
        Post::whereIn("user_id",$postid)->delete();
        return redirect()->route('posts.index')->with('success','All users deleted successfully');
    }
}

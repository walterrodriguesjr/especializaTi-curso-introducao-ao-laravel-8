<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePost;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate();
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(StoreUpdatePost $request)
    {
        $posts = Post::create([
            'title' => $request->title,
            'content' => $request->content
        ]);
        $posts->save();
        return redirect()->route('posts.index')->with('message', 'Post criado com sucesso!');
    }

    public function show($id)
    {
        $post = Post::find($id);
        return view('admin.posts.show', compact('post'));
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect()->route('posts.index')->with('message', 'Post deletado com sucesso!');
    }

    public function edit($id)
    {
        $post = Post::find($id);
        return view('admin.posts.edit', compact('post'));
    }

    public function update(StoreUpdatePost $request, $id)
    {
        $post = Post::find($id);
        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);
        return redirect()->route('posts.index')->with('message', 'Post atualizado com sucesso!');
    }

    public function search(Request $request)
    {
        $filters = $request->except('_token');

        $posts = Post::where('title', 'LIKE', "%{$request->search}%")
                     ->orWhere('content', 'LIKE', "%{$request->search}%")
                     ->paginate();
                     return view('admin.posts.index', compact('posts', 'filters'));
    }
}

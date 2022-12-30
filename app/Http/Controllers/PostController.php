<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePost;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            'content' => $request->content,
            'image' => $request->image
            ]);
            if($request->image->isValid()){
                //CAPTURA E PERSONALIZA O NOME DO ARQUIVO,COM NOME DO TITLE E O TIPO DE ARQUIVO
                $nameFile = Str::of($request->title)->slug('-') . '.' .$request->image->getClientOriginalExtension();
                
                $image = $request->image->storeAs('posts', $nameFile);
                $posts['image'] = $image;
            }
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

        if (Storage::exists($post->image)) {
            Storage::delete($post->image);
        }

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

        if($request->image && $request->image->isValid()){
            if (Storage::exists($post->image)) {
                Storage::delete($post->image);
            }

            //CAPTURA E PERSONALIZA O NOME DO ARQUIVO,COM NOME DO TITLE E O TIPO DE ARQUIVO
            $nameFile = Str::of($request->title)->slug('-') . '.' .$request->image->getClientOriginalExtension();
            
            $image = $request->image->storeAs('posts', $nameFile);
            $post['image'] = $image;
        }

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

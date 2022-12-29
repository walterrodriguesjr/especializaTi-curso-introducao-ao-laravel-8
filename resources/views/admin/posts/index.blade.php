@extends('admin.layouts.app')

@section('title', 'Listagem dos Posts')

@section('content')

    <a href="{{ route('posts.create') }}">Criar Novo Post</a>
    <hr>

    @if (session('message'))
        <div>
            {{ session('message') }}
        </div>
    @endif

    <form action="{{ route('posts.search') }}" method="post">
        @csrf
        <input type="text" name="search" placeholder="Digite...">
        <button type="submit">Pesquisar</button>
    </form>

    <h1>Posts</h1>
    <br>
    @foreach ($posts as $post)
        <p>{{ $post->title }} [
            <a href="{{ route('posts.show', $post->id) }}">Ver</a>
            <a href="{{ route('posts.edit', $post->id) }}">Editar</a>
            ]
        </p>
        <hr>
    @endforeach

    <hr>

    @if (isset($filters))
        {{ $posts->appends($filters)->links() }}
    @else
        {{ $posts->links() }}
    @endif

@endsection

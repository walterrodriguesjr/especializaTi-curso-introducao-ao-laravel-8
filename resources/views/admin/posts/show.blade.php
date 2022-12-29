@extends('admin.layouts.app')

@section('title', 'Visualizar Post')

@section('content')

    <h1>Detalhes do Post: {{ $post->title }}</h1>

    <ul>
        <li><strong>Título: </strong>{{ $post->title }}</li>
        <li><strong>Conteúdo: </strong>{{ $post->content }}</li>
        </li>
    </ul>

    <form action="{{ route('posts.destroy', $post->id) }}" method="post">
        @csrf
        @method('delete')
        <button type="submit">Deletar o post: {{ $post->title }}</button>
    </form>

@endsection

@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <h2>Editar Tópico</h2>
            <hr>
        </div>
        <div class="col-12">
            <form action="{{ route('threads.update', $thread->slug) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group mb-4">
                    <label for="title">Título Tópico</label>
                    <input type="text" id="title" class="form-control" name="title" value="{{$thread->title}}">
                </div>
                <div class="form-group">
                    <label for="body">Conteúdo Tópico</label>
                    <textarea name="body" id="body" cols="30" rows="10" class="form-control">
                        {{ $thread->body }}
                    </textarea>
                </div>
                <button class="btn btn-primary btn-sm mt-4" type="submit">Atualizar Tópico</button>
            </form>
        </div>
    </div>
@endsection
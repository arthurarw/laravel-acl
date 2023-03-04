@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <small>Criado por {{ $thread->user->name }} {{ $thread->created_at->diffForHumans() }}</small>
                </div>
                <div class="card-body">
                    <h2>{{ $thread->title }}</h2>
                    <p>
                        {{ $thread->body }}
                    </p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('threads.edit', $thread->slug) }}" class="btn btn-sm btn-primary">
                        Editar
                    </a>
                    <a href="#" class="btn btn-sm btn-danger" onclick="event.preventDefault(); document.querySelector('form.thread-rm').submit();">
                        Remover
                    </a>
                    <form action="{{ route('threads.destroy', $thread->slug) }}" method="POST" style="display: none;" class="thread-rm">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
            <hr>
        </div>
        <div class="col-12">
            <h5>Respostas</h5>
            <hr>
            @foreach ($thread->replies as $reply)
                <div class="card mt-3">
                    <div class="card-body">
                        {{$reply->reply}}
                    </div>
                    <div class="card-footer">
                        Respondido por: {{$reply->user->name}} {{ $reply->created_at->diffForHumans() }}
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-12">
            <hr>
            <form action="{{ route('replies.store') }}" method="POST">
                @csrf
                <input type="hidden" name="thread_id" value="{{$thread->id}}">
                <div class="form-group">
                    <label for="reply">Responder</label>
                    <textarea name="reply" id="reply" cols="30" rows="5" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-sm btn-success mt-3">Responder</button>
            </form>
        </div>
    </div>
@endsection
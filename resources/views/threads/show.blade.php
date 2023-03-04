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
    </div>
@endsection
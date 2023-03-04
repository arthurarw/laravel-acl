@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <h2>Tópicos</h2>
            <hr>
        </div>
    </div>
    <div class="col-12">
        @forelse ($threads as $item)
            <div class="list-group">
                <a href="{{ route('threads.show', $item->slug) }}" class="list-group-item list-group-item-action">
                    <h5>{{ $item->title }}</h5>
                    <small>Criado {{ $item->created_at->diffForHumans() }} por {{ $item->user->name }}</small>
                    <span class="badge bg-primary">{{$item->channel->name}}</span>
                </a>
            </div>
            
        @empty
            <div class="alert alert-warning">
                Nenhum tópico encontrado.
            </div>
        @endforelse

        {{ $threads->links() }}
    </div>
@endsection
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
                <a href="{{ route('threads.show', $item->slug) }}"
                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>
                        <h5>{{ $item->title }}</h5>
                        <small>Criado {{ $item->created_at->diffForHumans() }} por {{ $item->user->name }}</small>
                        <span class="badge bg-primary">{{ $item->channel->name }}</span>
                    </div>
                    <span class="badge bg-warning badge-pill">{{ $item->replies->count() }}</span>
                </a>
            </div>

        @empty
            <div class="alert alert-warning">
                Nenhum tópico encontrado.
            </div>
        @endforelse

        <div class="mt-3">
            {{ $threads->links() }}
        </div>
    </div>
@endsection

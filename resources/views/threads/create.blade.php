@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <h2>Criar Tópico</h2>
            <hr>
        </div>
        <div class="col-12">
            <form action="{{ route('threads.store') }}" method="POST">
                @csrf
                <div class="form-group mb-4">
                    <label for="title" class="form-label">Título Tópico</label>
                    <input type="text" id="title" class="form-control" name="title" value="{{ old('title') }}">
                </div>
                <div class="form-group mb-4">
                    <label for="channel_id" class="form-label">Canal</label>
                    <select name="channel_id" id="channel_id" class="form-select">
                        @foreach ($channels as $channel)
                            <option value="{{$channel->id}}">{{$channel->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="body" class="form-label">Conteúdo Tópico</label>
                    <textarea name="body" id="body" cols="30" rows="10" class="form-control">
                        {{ old('body') }}
                    </textarea>
                </div>
                <button class="btn btn-primary btn-sm mt-4" type="submit">Criar Tópico</button>
            </form>
        </div>
    </div>
@endsection
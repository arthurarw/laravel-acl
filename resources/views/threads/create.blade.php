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
                    <input type="text" id="title" class="form-control @error('title') is-invalid @enderror"
                        name="title" value="{{ old('title') }}">
                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group mb-4">
                    <label for="channel_id" class="form-label">Canal</label>
                    <select name="channel_id" id="channel_id" class="form-select @error('channel_id') is-invalid @enderror">
                        <option value="">Selecione um canal</option>
                        @foreach ($channels as $channel)
                            <option value="{{ $channel->id }}" @if (old('channel_id') == $channel->id) selected @endif>
                                {{ $channel->name }}</option>
                        @endforeach
                    </select>
                    @error('channel_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="body" class="form-label">Conteúdo Tópico</label>
                    <textarea name="body" id="body" cols="30" rows="10"
                        class="form-control @error('body') is-invalid @enderror">
                        {{ old('body') }}
                    </textarea>
                    @error('body')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button class="btn btn-primary btn-sm mt-4" type="submit">Criar Tópico</button>
            </form>
        </div>
    </div>
@endsection

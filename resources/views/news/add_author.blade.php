@extends('layouts.app')

@section('content')
    @component('_partials.container')
        <div class="card card-body">
            <form action="{{route('news.store.author', $news)}}" method="post">
                @csrf

                <div class="form-group">
                    <label for="email">Email автора</label>
                    <input type="text" name="email" placeholder="Введите email автора" class="form-control">
                    @error('email')
                        <div class="alert alert-danger">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <button class="btn btn-primary">Добавить</button>
                </div>
            </form>
        </div>
    @endcomponent
@endsection

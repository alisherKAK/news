@extends('layouts.app')

@section('content')
    @component('_partials.container')
    <form action="{{route('categories.store')}}" method="post">
        @csrf

        <div class="form-group">
            <label for="name">Имя</label>
            <input type="text" name="name" class="form-control" placeholder="Имя новой категори">
        </div>

        <button class="btn btn-primary">Создать</button>
    </form>
    @endcomponent
@endsection

@extends('layouts.app')

@section('content')
    @component('_partials.container')
    <div class="card card-body">
        <h2>Categories</h2>
        @if(optional(auth()->user())->role_id == 1)
            <a href="{{route('categories.create')}}" class="btn btn-outline-primary ml-auto mb-2">Новая категория</a>
        @endif
        <hr>
        @forelse($categories as $category)
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <h3>{{$category->name}}</h3>
                @if(optional(auth()->user())->role_id == 1)
                    <button class="btn btn-danger delete-btn" data-target="{{$category->id}}">Удалить</button>
                @endif
            </li>
        </ul>
        @empty
        <div class="alert alert-info">
            Пока нет категории...
        </div>
        @endforelse
    </div>
    @endcomponent

    @if(optional(auth()->user())->role_id == 1)
        <form id="delete-form" method="post">
            @csrf
            @method('delete')
        </form>

        <script>
            let deleteBtns = document.querySelectorAll('.delete-btn');
            for(let i = 0; i < deleteBtns.length; i++) {
                let deleteBtn = deleteBtns[i];
                let targetId = deleteBtn.dataset.target;
                deleteBtn.addEventListener('click', function (event) {
                    let form = document.getElementById('delete-form');
                    form.action = '/categories/' + targetId;
                    form.submit();
                });
            }
        </script>
    @endif

@endsection

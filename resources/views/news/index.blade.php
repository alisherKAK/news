@extends('layouts.app')

@section('content')
    @component('_partials.container')
    <div class="col-3">
        <div class="card">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <label for="news_search">Пойск</label>
                    <input type="search" name="news_search" id="news_search" class="form-control">
                </li>
                @if($categories ?? false)
                    <li class="list-group-item">
                        @foreach($categories as $category)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="category-{{$category->id}}">
                                <label for="category-{{$category->id}}" class="form-check-label">
                                    {{$category->name}}
                                </label>
                            </div>
                        @endforeach
                    </li>
                @endif
            </ul>
        </div>
    </div>
    <div class="col-9">
        @if(auth()->user())
            <a href="{{route('news.create')}}" class="btn btn-outline-primary ml-auto mb-2">Новая статья</a>
        @endif

        @forelse($newses as $news)
            @component('news._partials.news_block', ['news' => $news])@endcomponent
        @empty
            <div class="alert alert-info">
                Пока нет новостей...
            </div>
        @endforelse
    </div>
    @endcomponent
@endsection

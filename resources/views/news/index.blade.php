@extends('layouts.app')

@section('content')
    @component('_partials.container')
    <div class="col-3">
        @component('news._partials.search', ['categories' => $categories])@endcomponent
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

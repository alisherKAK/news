@extends('layouts.app')

@section('content')
    @component('_partials.container')

        @component('news._partials.actions', ['is_author' => $is_author, 'is_admin' => $is_admin, 'news' => $news])

            <div class="card col-12">
                <div class="card-header">
                    <img src="{{asset($news->title_img)}}" style="height: 100px" alt="Title image" class="card-img-top">
                    <h2>{{$news->title}}</h2>
                    <div>
                        <ul class="list-inline small">
                            <li class="list-inline-item">
                                Authors:
                            </li>
                            @foreach($authors as $author)
                            <li class="list-inline-item">
                                {{$author->name}}
                            </li>
                            @endforeach
                        </ul>
                        <h6 class="text-right">
                            Просмотров: {{$view_count}}
                        </h6>
                    </div>
                </div>
                <div class="card-body">
                    {!! $news->content !!}
                </div>
            </div>

        @endcomponent

        @if (auth()->check())

            @component('news._partials.comment_form', ['news' => $news])@endcomponent

        @endif

        @component('news._partials.comments_block', ['news' => $news])@endcomponent

    @endcomponent
@endsection

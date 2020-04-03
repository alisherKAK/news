<div class="card">
    <a href="{{route('news.show', $news)}}" class="card-header">
        <img src="{{asset($news->title_img)}}" style="height: 100px" alt="Title image" class="card-img-top">
        <h2>{{$news->title}}</h2>
    </a>
    <div class="card-body">
        {!! $news->content !!}
    </div>
</div>

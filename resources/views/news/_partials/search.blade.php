<div class="card">
    <form action="{{route('news.search')}}" method="post">
        @csrf
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <label for="news_search">Пойск</label>
                <input type="search" name="news_search" id="news_search" class="form-control">
            </li>
            @if($categories ?? false)
                <li class="list-group-item">
                    @foreach($categories as $category)
                        <div class="form-check">
                            <input type="checkbox" name="{{$category->id}}" class="form-check-input">
                            <label class="form-check-label">
                                {{$category->name}}
                            </label>
                        </div>
                    @endforeach
                </li>
            @endif
        </ul>
        <button id="search_btn" class="btn btn-dark form-control">Пойск</button>
    </form>
</div>

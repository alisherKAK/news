<?php
$id = \Illuminate\Support\Str::random();
?>

<div class="card mb-3 @if($active ?? false) bg-secondary @endif" style="width: 100%">

    @if($news ?? false)
        <a href="{{route('news.show', $comment->news)}}" class="card-header">{{$comment->news->title}}</a>
    @endif

    <div class="card-body">
        {{ $comment->content }}
    </div>

    <small class="card-footer d-flex align-items-center">
        <span>{{$comment->user->name}}</span>
        <span class="ml-auto">{{ $comment->created_at }}</span>

        @if($comment->user_id == optional(auth()->user())->id)
            <a href="{{ route('comments.destroy', $comment) }}"
               class=" btn btn-outline-danger border-0 btn-sm ml-2"
               id="comment-delete-{{$id}}"
               data-target="comment-delete-{{$comment->id}}">
                Удалить
            </a>

            <form id="comment-delete-{{$comment->id}}" action="{{ route('comments.destroy', $comment) }}"
                  method="post">
                @csrf
                @method('delete')
            </form>
        @endif
    </small>
</div>

@if($comment->user_id === optional(auth()->user())->id)
    <script>
        let delete_link = document.getElementById('comment-delete-{{$id}}');
        delete_link.addEventListener('click', function (event) {
            event.preventDefault();
            let target = delete_link.dataset.target;
            let form = document.getElementById(target);
            form.submit();
        });
    </script>
@endif

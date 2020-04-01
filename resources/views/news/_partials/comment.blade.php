<?php
$id = \Illuminate\Support\Str::random();
?>

<div class="card mb-3 @if($active ?? false) bg-secondary @endif">

    @if($post ?? false)
        <a href="{{route('posts.show', $comment->post)}}" class="card-header">{{$comment->post->title}}</a>
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
                  method="POST">
                @csrf @method('DELETE')
            </form>
        @endif
    </small>
</div>

@if($comment->user_id == optional(auth()->user())->id)
    <script>
        let deleteLink = document.getElementById('comment-delete-{{$id}}');
        deleteLink.addEventListener('click', function (event) {
            event.preventDefault();
            let target = deleteLink.dataset.target;
            let form = document.getElementById(target);
            form.submit();
        });
    </script>
@endif

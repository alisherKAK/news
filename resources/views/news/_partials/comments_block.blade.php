@forelse($news->comments as $comment)

    @component('news._partials.comment', [
        'news' => $news,
        'comment' => $comment,
        'active' => $comment->user_id === optional(auth()->user())->id
    ])@endcomponent

@empty
    <div class="alert alert-secondary" style="width: 100%">
        Пока нет комментариев. Будь первым!
    </div>
@endforelse


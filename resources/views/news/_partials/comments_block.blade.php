@forelse($post->comments as $comment)

    @component('posts._partials.comment', [
        'comment' => $comment,
        'active' => $comment->user_id === optional(auth()->user())->id
    ])@endcomponent

@empty
    <div class="alert alert-secondary">
        Пока нет комментариев. Будь первым!
    </div>
@endforelse


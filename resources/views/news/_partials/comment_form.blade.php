<form action="{{ route('comments.store') }}" method="POST" class="mb-3">
    @csrf

    <input type="hidden" name="post_id" value="{{ $post->id }}">
    <label for="content">Комментарий</label>

    @error('content')
    <div class="alert alert-danger mb-3">
        Ты должен написать комментарий. А не отправлять в пустую :(
    </div>
    @enderror

    <textarea name="content" id="content" class="form-control" placeholder="Ваш комментарий..."></textarea>

    <div>
        <button class="btn btn-secondary mt-2 btn-sm">Отправить</button>
    </div>
</form>

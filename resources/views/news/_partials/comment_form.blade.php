<form action="{{ route('comments.store') }}" method="POST" style="width: 100%">
    @csrf

    <input type="hidden" name="news_id" value="{{ $news->id }}" class="form-control">
    <label for="content">Комментарий</label>

    @error('content')
    <div class="alert alert-danger mb-3">
        Ты должен написать комментарий. А не отправлять в пустую :(
    </div>
    @enderror

    <div>
        <textarea name="content" id="content" class="form-control" placeholder="Ваш комментарий..."></textarea>
    </div>

    <div class="form-group">
        <button class="btn btn-secondary mt-2 btn-sm">Отправить</button>
    </div>
</form>

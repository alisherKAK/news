<form action="{{ route('comments.store') }}" method="POST" style="width: 100%" id="comment_form">
    @csrf

    <input type="hidden" name="news_id" value="{{ $news->id }}" class="form-control">
    <label for="content">Комментарий</label>

    @error('content')
    <div class="alert alert-danger mb-3">
        Ты должен написать комментарий. А не отправлять в пустую :(
    </div>
    @enderror

    <div>
        <textarea name="content" id="content" class="summernote form-control"></textarea>
    </div>

    <div class="form-group">
        <button class="btn btn-secondary mt-2 btn-sm">Отправить</button>
    </div>
</form>

<script>
    $('.summernote').summernote({
        placeholder: 'Ваш коментри',
        tabsize: 2,
        height: 120,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });

    $('#comment_form').on('submit', function (event) {
        let content = document.querySelector('.note-editable').innerHTML;
        let textarea = document.getElementById('summernote');
        textarea.innerHTML = content;
        return true;
    });
</script>

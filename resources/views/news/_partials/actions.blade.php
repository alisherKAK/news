@if($is_author)
    <a href="{{route('news.edit', $news)}}" class="btn btn-primary mb-2 mr-3">Редактировать</a>
    <a href="#" class="delete-link btn btn-danger mb-2 mr-3" data-target="delete-form">Удалить</a>
    <a href="{{route('news.add.author', $news)}}" class="btn btn-success mb-2 mr-3">Добавить автора</a>
@endif

    {{$slot}}

@if($is_author)
    <form id="delete-form" action="{{route('news.delete', $news)}}" method="post" style="display: none">
        @csrf
        @method('delete')
    </form>

    <script>
        let deleteLink = document.querySelector('.delete-link');
        let target = deleteLink.dataset.target;
        deleteLink.addEventListener('click', function (event) {
            event.preventDefault();
            console.log(5);
            let form = document.getElementById(target);
            form.submit();
        });
    </script>
@endif

<?php
$isEdit = isset($news);
?>

@extends('layouts.app')

@section('content')
    @component('_partials.container')
    <div class="card card-body">
    <form action="{{$isEdit ? route('news.update', $news) : route('news.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        @if($isEdit)
        @method('put')
        @endif
        <div class="form-group">
            <label for="title_img">Заголовочное изображение</label>
            <input type="file" name="title_img" accept="image/*" class="form-control-file">
            @error('title_img')
                <div class="alert alert-danger">
                    {{$message}}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="title">Заголовок</label>
            <input type="text" name="title" class="form-control"
                   value="{{old('title') ?? ($news->title ?? '')}}"
                   placeholder="Заголовок статьи">
            @error('title')
            <div class="alert alert-danger">
                {{$message}}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="content">Статья</label>
            <textarea name="content" id="" class="form-control">{{old('content') ?? ($news->content ?? '')}}</textarea>
            @error('content')
            <div class="alert alert-danger">
                {{$message}}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="category_id">Категория</label>
            <select name="category_id" class="form-control">
                <option value="">
                    Нет
                </option>
                @foreach($categories as $category)
                    <option value="{{$category->id}}">
                        {{$category->name}}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-success">Сохранить</button>
    </form>
        </div>
    @endcomponent
@endsection

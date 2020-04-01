<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use App\Models\NewsUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        return view('news.index', [
            'title' => 'Новости',
            'newses' => News::all(),
            'categories' => Category::all()
        ]);
    }

    public function create()
    {
        return view('news.form', [
            'title' => 'Новая статья',
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());

        $file = $request->file('title_img');
        $path = $this->updateFile($file);

        $news = new News($request->except(['_token', 'title_img']));
        $news->title_img = $path;
        $news->save();

        $user_news = new NewsUser();
        $user_news->user_id = optional(auth()->user())->id;
        $user_news->news_id = $news->id;
        $user_news->save();

        return redirect()->route('news.index');
    }

    public function show(News $news)
    {
        $isAuthor = auth()->user() !== null ?
            optional(auth()->user())->news->where('id', $news->id)->toArray() : false;
        $authors = $news->users;

        return view('news.show', [
            'title' => $news->title,
            'news' => $news,
            'is_author' => $isAuthor,
            'authors' => $authors
        ]);
    }

    public function edit(News $news)
    {
        return view('news.form', [
            'title' => 'Изменить',
            'categories' => Category::all(),
            'news' => $news
        ]);
    }

    public function update(Request $request, News $news)
    {
        $request->validate($this->rules());

        $file = $request->file('title_img');
        $path = $this->updateFile($file);

        $data = $request->except(['_token', '_method', 'title_img']);
        $news->update($data);
        $news->title_img = $path;
        $news->save();

        return redirect()->route('news.show', $news);
    }

    public function destroy(News $news)
    {
        $path = $news->title_img;
        $path = str_replace('uploads', 'public', $path);
        Storage::delete($path);

        $news->delete();
        return redirect()->route('news.index');
    }

    public function addAuthor(News $news) {
        return view('news.add_author', [
            'title' => 'Новый автор',
            'news' => $news
        ]);
    }

    public function storeAuthor(Request $request, News $news) {
        $request->validate([
           'email' => 'required'
        ]);

        $email = $request->input('email');
        $user = User::all()->where('email', $email)->first();

        $newsUser = NewsUser::all()->where('user_id', $user->id)->where('news_id', $news->id)->first();
        if($newsUser !== null)
            return redirect()->route('news.show', $news);

        $newsUser = new NewsUser();
        $newsUser->user_id = $user->id;
        $newsUser->news_id = $news->id;
        $newsUser->save();

        return redirect()->route('news.show', $news);
    }

    protected function rules() {
        return [
            'title' => 'required',
            'content' => 'required',
            'title_img' => 'required'
        ];
    }

    protected function updateFile($file, $oldPath = '') {
        $oldPath = str_replace('uploads', 'public', $oldPath);
        if(Storage::exists($oldPath))
            Storage::delete($oldPath);

        $name = Str::random();
        $file->storeAs('public/images/',"{$name}.{$file->extension()}");
        $path = 'uploads/images/' . "{$name}.{$file->extension()}";
        return $path;
    }
}

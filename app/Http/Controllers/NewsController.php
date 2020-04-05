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

    public function show(Request $request, News $news)
    {
        $view = $news->views()->where('client_ip', $request->getClientIp())->first();
        if($view === null)
            $view = $news->views()->create(['client_ip' => $request->getClientIp()]);

        $geo_location = $this->getGeolocationFromIp($view->client_ip);

        $view->country_name = $geo_location['country_name'];
        $view->save();

        $isAuthor = auth()->user() !== null ?
            optional(auth()->user())->news->where('id', $news->id)->toArray() : false;
        $authors = $news->users;

        return view('news.show', [
            'title' => $news->title,
            'news' => $news,
            'is_author' => $isAuthor,
            'is_admin' => optional(auth()->user())->role_id === 1,
            'authors' => $authors,
            'view_count' => $news->views()->count()
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
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $file = $request->file('title_img');

        if($file !== null)
            $path = $this->updateFile($file);
        else
            $path = $news->title_img;

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

    public function search(Request $request) {
        $newses = News::all();

        $phrase = trim($request->input('news_search'), " \t\n\r\0\x0B");
        $categories = $request->except(['_token', 'news_search']);

        foreach($categories as $key => $value) {
            $newses = News::all()->where('category_id', $key);
        }

        foreach ($newses as $news) {
            if($news->getFirstTitleLetters(strlen($phrase)) !== $phrase) {
                $newses = $newses->reject($news);
            }
        }

        return view('news.index', [
            'title' => 'Новости',
            'newses' => $newses,
            'categories' => Category::all()
        ]);
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

    protected function getGeolocationFromIp($ip) {
        $apiKey = config('external_api_keys.ip_geolocation');
        $location = $this->get_geolocation($apiKey, '77.245.96.19');
        $decodedLocation = json_decode($location, true);

        return $decodedLocation;
    }

    protected function get_geolocation($apiKey, $ip, $lang = "en", $fields = "*", $excludes = "") {
        $url = "https://api.ipgeolocation.io/ipgeo?apiKey=".$apiKey."&ip=".$ip."&lang=".$lang."&fields=".$fields."&excludes=".$excludes;
        $cURL = curl_init();

        curl_setopt($cURL, CURLOPT_URL, $url);
        curl_setopt($cURL, CURLOPT_HTTPGET, true);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json'
        ));
        return curl_exec($cURL);
    }
}

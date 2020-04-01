<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\User;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function index() {
        return view('categories.index', [
           'title' => 'Категории',
           'categories' => Category::all()
        ]);
    }

    function create() {
        return view('categories.form',[
           'title' => 'Новая категория'
        ]);
    }

    function store(Request $request) {
        $request->validate([
           'name' => 'required|max:255'
        ]);

        $data = $request->except('_token');

        /** @var User $user */
        $category = new Category($data);
        $category->save();

        return redirect()->route('categories.index');
    }

    function destroy(Category $category) {
        $category->delete();
        return redirect()->route('categories.index');
    }
}

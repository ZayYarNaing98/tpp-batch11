<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::get();

        return view('categories.index', [
            'data' => $categories
        ]);
    }

    public function edit($id)
    {
        $category = Category::find($id);

        return view('categories.edit', compact('category'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        Category::create($request->all());

        return redirect()->route('categories.index');
    }

    public function update(Request $request)
    {
        $category = Category::find($request->id);

        $category->update([
            'name' => $request->name
        ]);

        return redirect()->route('categories.index');
    }

    public function delete($id)
    {
        $category = Category::find($id);

        $category->delete();

        return redirect()->route('categories.index');
    }
}

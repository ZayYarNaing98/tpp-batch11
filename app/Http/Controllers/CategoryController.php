<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::get();

        // dd($categories);

        return view('categories.index', compact('categories'));
    }

    public function edit($id)
    {
        // dd('here');
        // dd($id);
        $category = Category::find($id);
        // dd($category);

        return view('categories.edit', compact('category'));
    }
}

<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function index()
    {
        return Category::get();
    }

    public function show($id)
    {
        return Category::find($id);
    }

    public function store($data)
    {
        return Category::create($data);
    }
}

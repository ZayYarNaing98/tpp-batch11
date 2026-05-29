<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCategoryRequest;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryRepository;
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $categories = $this->categoryRepository->index();

        return view('categories.index', [
            'data' => $categories
        ]);
    }

    public function edit($id)
    {
        $category = $this->categoryRepository->show($id);

        return view('categories.edit', compact('category'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string'
        ]);
        $this->categoryRepository->store($data);

        return redirect()->route('categories.index');
    }

    public function update(UpdateCategoryRequest $request)
    {

        $category = $this->categoryRepository->show($request->id);

        $category->update([
            'name' => $request->name
        ]);

        return redirect()->route('categories.index');
    }

    public function delete($id)
    {
        $category = $this->categoryRepository->show($id);


        $category->delete();

        return redirect()->route('categories.index');
    }
}

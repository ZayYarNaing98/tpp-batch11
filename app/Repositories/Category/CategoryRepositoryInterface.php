<?php

namespace App\Repositories\Category;


interface CategoryRepositoryInterface
{
    public function index();

    public function show($id);

    public function store($data);
}

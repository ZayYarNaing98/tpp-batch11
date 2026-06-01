<?php

namespace App\Providers;

use App\Repositories\Batch\BatchRepository;
use App\Repositories\Batch\BatchRepositoryInterface;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Instructor\InstructorRepository;
use App\Repositories\Instructor\InstructorRepositoryInterface;
use App\Repositories\Student\StudentRepository;
use App\Repositories\Student\StudentRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->singleton(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->singleton(BatchRepositoryInterface::class, BatchRepository::class);
        $this->app->singleton(InstructorRepositoryInterface::class, InstructorRepository::class);
        $this->app->singleton(StudentRepositoryInterface::class, StudentRepository::class);
    }
}

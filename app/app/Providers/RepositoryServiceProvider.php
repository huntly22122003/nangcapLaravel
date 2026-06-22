<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Eloquent\ProductRepository;
use App\Services\Interfaces\ProductServiceInterface;
use App\Services\Admin\ProductService;
use App\Repositories\Interfaces\BannerRepositoryInterface;
use App\Repositories\Eloquent\BannerRepository;
use App\Services\Interfaces\BannerServiceInterface;
use App\Services\Admin\BannerService;
use App\Repositories\Interfaces\CategoryRepositoryInterface; 
use App\Repositories\Eloquent\CategoryRepository; 
use App\Services\Interfaces\CategoryServiceInterface;
use App\Services\Admin\CategoryService; 

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //Products
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        //Banners
        $this->app->bind(BannerRepositoryInterface::class, BannerRepository::class);
        $this->app->bind(BannerServiceInterface::class, BannerService::class);
        // Category
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
    }

    public function boot(): void
    {
        //
    }
}
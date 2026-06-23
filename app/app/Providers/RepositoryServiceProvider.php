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
// app/Providers/RepositoryServiceProvider.php
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Eloquent\UserRepository;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\Admin\UserService;

use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Eloquent\PostRepository;
use App\Services\Interfaces\PostServiceInterface;
use App\Services\Admin\PostService;

use App\Repositories\Interfaces\GalleryRepositoryInterface;
use App\Repositories\Eloquent\GalleryRepository;
use App\Services\Interfaces\GalleryServiceInterface;
use App\Services\Admin\GalleryService;

// Thêm các use statement cho Contact
use App\Repositories\Interfaces\ContactRepositoryInterface;
use App\Repositories\Eloquent\ContactRepository;
use App\Services\Interfaces\ContactServiceInterface;
use App\Services\Admin\ContactService;

// Thêm các use statement cho Faq
use App\Repositories\Interfaces\FaqRepositoryInterface;
use App\Repositories\Eloquent\FaqRepository;
use App\Services\Interfaces\FaqServiceInterface;
use App\Services\Admin\FaqService;

// Thêm các use statement cho Page
use App\Repositories\Interfaces\PageRepositoryInterface;
use App\Repositories\Eloquent\PageRepository;
use App\Services\Interfaces\PageServiceInterface;
use App\Services\Admin\PageService;

//  thêm các use staement cho Order
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Eloquent\OrderRepository;
use App\Services\Interfaces\OrderServiceInterface;
use App\Services\Admin\OrderService;

use App\Repositories\Interfaces\ProductPostRepositoryInterface;
use App\Repositories\Eloquent\ProductPostRepository;
use App\Services\Interfaces\ProductPostServiceInterface;
use App\Services\Admin\ProductPostService;
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
        // Trong register()
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        // Post
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class); 
        $this->app->bind(PostServiceInterface::class, PostService::class);
        // Gallery
        $this->app->bind(GalleryRepositoryInterface::class, GalleryRepository::class);
        $this->app->bind(GalleryServiceInterface::class, GalleryService::class);
        // Contact
        $this->app->bind(ContactRepositoryInterface::class, ContactRepository::class);
        $this->app->bind(ContactServiceInterface::class, ContactService::class);
        // Faq
        $this->app->bind(FaqRepositoryInterface::class, FaqRepository::class);
        $this->app->bind(FaqServiceInterface::class, FaqService::class);
        // Page
        $this->app->bind(PageRepositoryInterface::class, PageRepository::class);
        $this->app->bind(PageServiceInterface::class, PageService::class);
        // Order
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(OrderServiceInterface::class, OrderService::class);
        // Product Post
        $this->app->bind(ProductPostRepositoryInterface::class, ProductPostRepository::class);
        $this->app->bind(ProductPostServiceInterface::class, ProductPostService::class);
    }

    public function boot(): void
    {
        //
    }
}
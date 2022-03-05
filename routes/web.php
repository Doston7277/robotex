<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Front\ShoppingController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\BlogController;
use App\Http\Controllers\Front\AboutController;
use App\Http\Controllers\Front\ContactController;

Route::group(['middleware' => ['language']], function () {

    Route::get('/lang/{lang}',                      [LanguageController::class, 'index']);
    Route::get('/',                                 [FrontController::class, 'index'])->name('home');
    Route::get('/products',                         [ProductController::class, 'index']);
    Route::get('/blog',                             [BlogController::class, 'index']);
    Route::get('/about',                            [AboutController::class, 'index']);
    Route::get('/contact',                          [ContactController::class, 'index']);
    Route::get('/shopping-cart',                    [ShoppingController::class, 'shopping_card']);

    Route::get('/cart/add/{product_id}',            [CartController::class, 'create']);
    Route::get('/cart/delete/{rowId}',              [CartController::class, 'delete']);

});

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LoginController as AdminLogin;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProduct;
use App\Http\Controllers\Admin\BlogController as AdminBlog;
use App\Http\Controllers\Admin\OrderController as AdminOrder;

Route::get('/admin/login',                          [AdminLogin::class, 'login'])->name('admin-login');
Route::post('/admin/login',                         [AdminLogin::class, 'login_check'])->name('admin-login-check');

Route::group(['prefix' => 'admin','as'=>'admin.', 'middleware' => ['isAdmin']], function () {

    Route::get('/',                                 [AdminController::class, 'index'])->name('dashboard');
    Route::get('/admin',                            [AdminController::class, 'index_admin'])->name('admin');
    Route::get('/admins',                           [AdminController::class, 'index_admin_create'])->name('admin-create');
    Route::post('/admin/create',                    [AdminController::class, 'admin_create']);
    Route::get('/admin/delete/{user_id}',           [AdminController::class, 'admin_delete']);
    Route::get('/admin/update/{user_id}',           [AdminController::class, 'admin_edit']);
    Route::post('/admin/update',                    [AdminController::class, 'update'])->name('admin-update');
    Route::post('/admin/datatable',                 [AdminController::class, 'datatable']);
    Route::post('/admin/upload',                    [AdminController::class, 'upload']);

    Route::get('/users',                            [AdminUser::class, 'index'])->name('users');
    Route::get('/user',                             [AdminUser::class, 'index_create'])->name('user-create');
    Route::post('/user/upload',                     [AdminUser::class, 'upload']);
    Route::get('/user/update/{user_id}',            [AdminUser::class, 'edit']);
    Route::post('/user/update',                     [AdminUser::class, 'update'])->name('user-update');
    Route::post('/user/create',                     [AdminUser::class, 'create']);
    Route::post('/users/datatable',                 [AdminUser::class, 'datatable']);
    Route::get('/user/delete/{user_id}',            [AdminUser::class, 'delete']);

    Route::get('/category',                         [CategoryController::class, 'index'])->name('category');
    Route::post('/category/datatable',              [CategoryController::class, 'datatable']);
    Route::get('/category/create',                  [CategoryController::class, 'index_create'])->name('category-create');
    Route::post('/category/create',                 [CategoryController::class, 'create']);
    Route::get('/category/delete/{category_id}',    [CategoryController::class, 'delete']);
    Route::get('/category/update/{category_id}',    [CategoryController::class, 'edit']);
    Route::post('/category/update',                 [CategoryController::class, 'update'])->name('category-update');
    Route::get('/category/select/',                 [CategoryController::class, 'select']);

    Route::get('/product',                          [AdminProduct::class, 'index'])->name('product');
    Route::get('/product/create',                   [AdminProduct::class, 'index_create'])->name('product-create');
    Route::post('/product/create',                  [AdminProduct::class, 'create']);
    Route::post('/product/datatable',               [AdminProduct::class, 'datatable']);
    Route::post('/product/upload',                  [AdminProduct::class, 'uploads']);
    Route::delete('/photo/delete',                  [AdminProduct::class, 'delete']);
    Route::get('/product/update/{product_id}',      [AdminProduct::class, 'edit']);
    Route::post('/product/update',                  [AdminProduct::class, 'update'])->name('product-update');
    Route::get('/product/delete/{product_id}',      [AdminProduct::class, 'delete']);


    Route::get('/blog',                             [AdminBlog::class, 'index'])->name('blog');
    Route::post('/blog/datatable',                  [AdminBlog::class, 'datatable']);
    Route::get('/blog/create',                      [AdminBlog::class, 'index_create'])->name('blog-create');
    Route::post('/blog/update',                     [AdminBlog::class, 'update'])->name('blog-update');
    Route::get('/blog/update/{blog_id}',            [AdminBlog::class, 'edit']);
    Route::post('/blog/create',                     [AdminBlog::class, 'create']);
    Route::get('/blog/delete/{blog_id}',            [AdminBlog::class, 'delete']);
    Route::post('/blog/upload',                     [AdminBlog::class, 'upload']);

    Route::get('/orders',                           [AdminOrder::class, 'orders'])->name('orders');
    Route::post('/order/datatable',                 [AdminOrder::class, 'datatable']);
    Route::get('/order/{order_id}',                 [AdminOrder::class, 'detail']);
});

Route::get('/logout', function (){
    \Illuminate\Support\Facades\Auth::logout();
    return back();
})->name('logout');

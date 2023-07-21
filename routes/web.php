<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\User\AjaxController;
use App\Http\Controllers\User\UserController;

Route::middleware(['admin_auth'])->group(function(){
    //login, register
    Route::redirect('/','loginPage');
    Route::get('loginPage',[AuthController::class,'loginPage'])->name('auth#loginPage');
    Route::get('registerPage',[AuthController::class,'registerPage'])->name('auth#registerPage');
});

Route::middleware(['auth'])->group(function () {
    //dashboard
    Route::get('dashboard',[AuthController::class,'dashboard']);

    Route::middleware(['admin_auth'])->group(function(){
        //category
         Route::prefix('category')->group(function(){
        Route::get('list',[CategoryController::class,'list'])->name('category#list');
        Route::get('create',[CategoryController::class,'create'])->name('category#create');
        Route::post('createPage',[CategoryController::class,'createPage'])->name('category#createPage');
        Route::get('delete/{id}',[CategoryController::class,'delete'])->name('categeory#delete');
        Route::get('edit/{id}',[CategoryController::class,'edit'])->name('category#edit');
        Route::post('update/{id}',[CategoryController::class,'update'])->name('category#update');

    });
    //admin account
    Route::prefix('admin')->group(function(){
        //change password
        Route::get('changePass',[AdminController::class,'changePass'])->name('admin#changePass');
         Route::post('change',[AdminController::class,'change'])->name('admin#change');

         //profile
         Route::get('details',[AdminController::class,'details'])->name('admin#profile');
        Route::get('editprofile',[AdminController::class,'editprofile'])->name('admin#editprofile');
        Route::post('update/{id}',[AdminController::class,'update'])->name('admin#update');

        //admin list
        Route::get('list',[AdminController::class,'list'])->name('admin#list');
        Route::get('delete/{id}',[AdminController::class,'delete'])->name('admin#delete');
        Route::get('changeRole',[AdminController::class,'changeRole'])->name('admin#changeRole');
        Route::post('updateRole/{id}',[AdminController::class,'updateRole'])->name('admin#updateRole');

        //contact list
        Route::get('contactList',[AdminController::class,'contactList'])->name('admin#contactList');
        Route::get('deleteList/{id}',[AdminController::class,'deleteList'])->name('admin#deleteList');
    });

    //product
    Route::prefix('product')->group(function(){
        Route::get('list',[ProductController::class,'list'])->name('product#list');
        Route::get('create',[ProductController::class,'create'])->name('product#create');
        Route::post('createPage',[ProductController::class,'createPage'])->name('product#createPage');
        Route::get('delete/{id}',[ProductController::class,'delete'])->name('product#delete');
        Route::get('view/{id}',[ProductController::class,'view'])->name('product#view');
        Route::get('edit/{id}',[ProductController::class,'edit'])->name('product#edit');
        Route::post('update',[ProductController::class,'update'])->name('product#update');
    });

     Route::prefix('order')->group(function(){
        Route::get('list',[OrderController::class,'list'])->name('order#list');
        Route::get('orderStatus',[OrderController::class,'orderStatus'])->name('order#orderStatus');
        Route::get('changeStatus',[OrderController::class,'changeStatus'])->name('order#changeStatus');
        Route::get('code/{orderCode}',[OrderController::class,'code'])->name('order#code');
    });

     Route::prefix('user')->group(function(){
        Route::get('userList',[UserController::class,'userList'])->name('user#userList');
        Route::get('changeRole',[UserController::class,'changeRole'])->name('user#changeRole');
        Route::get('deleteUser/{id}',[UserController::class,'deleteUser'])->name('user#deleteUser');
    });
    });


//user
    Route::group(['prefix'=>'user','middleware'=>'user_auth'],function(){
        Route::get('home',[UserController::class,'home'])->name('user#home');
        Route::get('filter/{id}',[UserController::class,'filter'])->name('user#filter');

        //change password
        Route::get('changePass',[UserController::class,'changePass'])->name('user#changePass');
        Route::post('updatePass',[UserController::class,'updatePass'])->name('user#updatePass');

        //acc change
        Route::get('editAcc',[UserController::class,'editAcc'])->name('user#editAcc');
        Route::post('updateAcc/{id}',[UserController::class,'updateAcc'])->name('user#updateAcc');

        //detal
        Route::get('detail/{id}',[UserController::class,'detail'])->name('user#detail');

        //cart
        Route::get('cartList',[UserController::class,'cartList'])->name('user#cartList');
        //history
        Route::get('history',[UserController::class,'history'])->name('user#history');
        //contact
        Route::get('contact',[ContactController::class,'contact'])->name('user#contact');
        Route::post('contactUs',[ContactController::class,'contactUs'])->name('user#contactUs');

        Route::prefix('ajax')->group(function(){
            Route::get('pizzalist',[AjaxController::class,'pizzalist'])->name('ajax#pizzalist');
            Route::get('addToCart',[AjaxController::class,'addToCart'])->name('ajax#addToCart');
            Route::get('order',[AjaxController::class,'order'])->name('ajax#order');
            Route::get('clear',[AjaxController::class,'clearCart'])->name('ajax#clearCart');
            Route::get('current',[AjaxController::class,'current'])->name('ajax#current');
            Route::get('increaseView',[AjaxController::class,'increaseView'])->name('ajax#increaseView');
        });
    });
});



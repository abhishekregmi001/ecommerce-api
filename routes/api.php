<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductSubCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\CostumerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogTagsController;
use App\Http\Controllers\BlogPostTagsController;
use App\Http\Controllers\BlogController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api'], function($router) {
    Route::post('/register', [JWTController::class, 'register']);
    Route::post('/login', [JWTController::class, 'login']);
    Route::post('/logout', [JWTController::class, 'logout']);
    Route::post('/refresh', [JWTController::class, 'refresh']);
    Route::post('/profile', [JWTController::class, 'profile']);
    Route::post('/updateProfile/{id}', [CostumerController::class, 'updateProfile']);
    Route::post('/getProfile/{id}', [JWTController::class, 'getProfile']);
    Route::post('/addPCategory',[ProductCategoryController::class,'addPCategory']);
    Route::post('/updatePCategory/{id}',[ProductCategoryController::class,'updatePCategory']);
    Route::post('/addPSCategory',[ProductSubCategoryController::class,'addPSCategory']);
    Route::post('/updatePSCategory/{id}',[ProductSubCategoryController::class,'updatePSCategory']);
    Route::post('/addProduct',[ProductController::class,'addProduct']);
    Route::post('/updateProduct/{id}',[ProductController::class,'updateProduct']);
    Route::post('/Pdelete/{id}',[ProductController::class,'Pdelete']);
    Route::post('/searchProduct',[ProductController::class,'searchProduct']);
    Route::post('/product_info/{id}',[ProductController::class,'product_info']);
    Route::post('/Pcdelete/{id}',[ProductCategoryController::class,'Pcdelete']);
    Route::post('/Pcshow/{id}',[ProductCategoryController::class,'Pcshow']);
    Route::post('/Pscdelete/{id}',[ProductSubCategoryController::class,'Pscdelete']);
    Route::post('/Pscshow/{id}',[ProductSubCategoryController::class,'Pscshow']);
    Route::post('/order/{id}',[AdminController::class,'order']);
    Route::post('/update/{id}',[AdminController::class,'update']);
    Route::post('/updateOrder/{id}',[OrderController::class,'updateOrder']);
    Route::post('/admin/create_blogcategory',[BlogCategoryController::class,'cBlogCategory']);
    Route::post('/admin/update_blogcategory/{id}',[BlogCategoryController::class,'uBlogCategory']);
    Route::post('/admin/blog-status/{id}',[BlogCategoryController::class,'blogStatus']);
    Route::get('/admin/blog-category',[BlogCategoryController::class,'blogCategory']);
    Route::post('/admin/create_blogtags',[BlogTagsController::class,'createblogtags']);
    Route::post('/admin/update_blogtags/{id}',[BlogTagsController::class,'updateblogtags']);
    Route::post('/admin/blogtag_status/{id}',[BlogTagsController::class,'tagStatus']);
    Route::post('/admin/tags_list',[BlogTagsController::class,'tagList']);
    
    Route::post('/admin/create_posttag',[BlogPostTagsController::class,'createpostags']);
    Route::post('/admin/update_posttags/{id}',[BlogPostTagsController::class,'updatepostags']);
    Route::post('/admin/upost_tagstatus/{id}',[BlogPostTagsController::class,'postStatus']);
    Route::get('/admin/post_tags',[BlogPostTagsController::class,'tagList']);

});

Route::group(['middleware' => ['api']], function($router) {
    Route::post('/cregister', [CostumerController::class, 'cregister']);
    Route::post('/clogin', [CostumerController::class, 'clogin']);
    Route::post('/clogout', [CostumerController::class, 'clogout']);
    Route::post('/crefresh', [CostumerController::class, 'crefresh']);
    Route::post('/cprofile', [CostumerController::class, 'cprofile']);
    Route::post('/change-password', [CostumerController::class, 'cpassword']);
    Route::post('/addcart',[CartController::class,'addcart']);
    Route::post('/showcart/{id}',[CartController::class,'showcart']);
    Route::post('/deletecart/{id}',[CartController::class,'deletecart']);
    Route::post('/addorder',[OrderController::class,'addorder']);
    Route::post('/showorder/{id}',[OrderController::class,'showorder']);
    Route::post('/deleteorder/{id}',[OrderController::class,'deleteorder']);
    Route::post('/addod',[OrderDetailController::class,'addod']);
    Route::post('/showod/{id}',[OrderDetailController::class,'showod']);
    Route::post('/deleteod/{id}',[OrderDetailController::class,'deleteod']);
});

    Route::get('/blog-category/{id}',[BlogController::class,'blogcategory']);
    // Route::get('/blogs',[BlogController::class,'blogs']);
    // Route::get('/blog-category',[BlogController::class,'blogcategory']);


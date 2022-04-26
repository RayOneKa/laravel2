<?php

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user()->load(['roles', 'addresses']);
});

Route::post('/test', function () {
    $id = request('id');
    if (!$id) {
        return User::get();
    }
    
    return [User::findOrFail($id)];
});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/test/test', [HomeController::class, 'testtest']);


Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/', "App\Http\Controllers\AdminController@admin")->name('admin');
    Route::get('/users', [AdminController::class, 'users'])->name('adminUsers');
    Route::get('/products', [AdminController::class, 'products'])->name('adminProducts');
    Route::get('/categories', [AdminController::class, 'categories'])->name('adminCategories');
    Route::get('/enterAsUser/{id}', [AdminController::class, 'enterAsUser'])->name('enterAsUser');
    Route::post('/exportCategories', [AdminController::class, 'exportCategories']);
    Route::prefix('roles')->group(function() {
        Route::post('/add', [AdminController::class, 'addRole'])->name('addRole');
        Route::post('/addRoleToUser', [AdminController::class, 'addRoleToUser'])->name('addRoleToUser');
    });
});

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'cart'])->name('cart');
    Route::get('/info', [CartController::class, 'info']);
    Route::get('/productsQuantity', [CartController::class, 'productsQuantity']);;
    Route::post('/removeFromCart', [CartController::class, 'removeFromCart'])->name('removeFromCart');
    Route::post('/addToCart', [CartController::class, 'addToCart'])->name('addToCart');
    Route::post('/createOrder', [CartController::class, 'createOrder'])->name('createOrder');
});

Route::get('/getCategories', [HomeController::class, 'getCategories']);
Route::get('/category/{category}', [HomeController::class, 'category'])->name('category');
Route::get('/category/{category}/getProducts', [HomeController::class, 'getProducts']);
Route::get('/profile/{user}', [ProfileController::class, 'profile'])->name('profile');
Route::post('/profile/save', [ProfileController::class, 'save'])->name('saveProfile');

// Auth::routes();

Route::prefix('auth')->group(function () {
    Route::get('/login', [LoginController::class, 'login']);
    Route::get('/logout', [LoginController::class, 'logout']);
    Route::get('/register', [RegisterController::class, 'register']);
});
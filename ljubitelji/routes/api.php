<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPostController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// ---  USER-POST RUTE  --- //
Route::get('/users/{id}/posts', [UserPostController::class, 'index'])->name('users.posts.index');
//Route::resource('users.posts', UserPostController::class)->name('users.posts.index')->only('index');


// ---  USER RUTE  --- //
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');


// ---  POST RUTE   --- //
// Route::get('/posts', [PostController::class, 'index']);
// Route::get('/posts/{id}', [PostController::class, 'show']);
//Route::resource('/posts', PostController::class)->only('destroy'); // brisanje posta iz baze
//Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
Route::resource('/posts', PostController::class)->only('index');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');


// ---    COMMENT RUTE    --- //
Route::get('/comments', [CommentController::class, 'index']);


// ---   Registrovanje & Login  --- //
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// ---    Middleware - omogucava da ne moze da se pristupi ovim rutama ako korisnik nije autorizovan   --- //
Route::group(['middleware'=>['auth:sanctum']], function(){
    Route::get('/profile', function (Request $request){
        return auth()->user();
    });
    Route::resource('posts', PostController::class)->only(['editPostText','store','destroy']);
    //Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/logout', [AuthController::class, 'logout']);
});


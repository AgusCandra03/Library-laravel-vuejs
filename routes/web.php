<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('test_spatie', [App\Http\Controllers\HomeController::class, 'test_spatie']);

// Route::get('/authors', [App\Http\Controllers\AuthorController::class, 'index']);
// Route::get('/authors/create', [App\Http\Controllers\AuthorController::class, 'create']);
// Route::post('/authors', [App\Http\Controllers\AuthorController::class, 'store']);
// Route::get('/authors/{author}/edit', [App\Http\Controllers\AuthorController::class, 'edit']);
// Route::put('/authors/{author}', [App\Http\Controllers\AuthorController::class, 'update']);
// Route::delete('/authors/{author}', [App\Http\Controllers\AuthorController::class, 'destroy']);

Route::resource('/authors', App\Http\Controllers\AuthorController::class);
Route::resource('/publishers', App\Http\Controllers\PublisherController::class);
Route::resource('/catalogs', App\Http\Controllers\CatalogController::class);
Route::resource('/members', App\Http\Controllers\MemberController::class);
Route::resource('/books', App\Http\Controllers\BookController::class);
Route::resource('/transactions', App\Http\Controllers\TransactionController::class);
Route::resource('/transaction_details', App\Http\Controllers\TransactionDetailController::class);
Route::resource('/notifications', App\Http\Controllers\NotificationController::class);

// Route::get('/catalogs', [App\Http\Controllers\CatalogController::class, 'index']);
// Route::get('/catalogs/create', [App\Http\Controllers\CatalogController::class, 'create']);
// Route::post('/catalogs', [App\Http\Controllers\CatalogController::class, 'store']);
// Route::get('/catalogs/{catalog}/edit', [App\Http\Controllers\CatalogController::class, 'edit']);
// Route::put('/catalogs/{catalog}', [App\Http\Controllers\CatalogController::class, 'update']);
// Route::delete('/catalogs/{catalog}', [App\Http\Controllers\CatalogController::class, 'destroy']);

// Route::get('/books', [App\Http\Controllers\BookController::class, 'index']);
// Route::get('/members', [App\Http\Controllers\MemberController::class, 'index']);
// Route::get('/publishers', [App\Http\Controllers\PublisherController::class, 'index']);
// Route::get('/transactions', [App\Http\Controllers\TransactionController::class, 'index']);
// Route::get('/transactionDetails', [App\Http\Controllers\TransactionDetailController::class, 'index']);


Route::get('/api/publishers', [App\Http\Controllers\PublisherController::class, 'api']);
Route::get('/api/authors', [App\Http\Controllers\AuthorController::class, 'api']);
Route::get('/api/catalogs', [App\Http\Controllers\CatalogController::class, 'api']);
Route::get('/api/members', [App\Http\Controllers\MemberController::class, 'api']);
Route::get('/api/books', [App\Http\Controllers\BookController::class, 'api']);
Route::get('/api/transactions', [App\Http\Controllers\TransactionController::class, 'api']);
Route::get('/api/transaction_details', [App\Http\Controllers\TransactionDetailController::class, 'api']);
Route::get('/api/notifications', [App\Http\Controllers\NotificationController::class, 'api']);
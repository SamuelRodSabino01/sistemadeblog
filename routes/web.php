<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rotas públicas do blog
Route::get('/', [BlogController::class, 'index'])->name('blog.index');
Route::get('/post/{post:slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/category/{category:slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/tag/{tag:slug}', [BlogController::class, 'tag'])->name('blog.tag');
Route::get('/search', [BlogController::class, 'search'])->name('blog.search');
Route::get('/contact', [BlogController::class, 'contact'])->name('blog.contact');
Route::post('/contact', [BlogController::class, 'contactStore'])->name('contact.store');

// Rotas de comentários
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

// Rotas de autenticação padrão do Laravel Breeze
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->is_admin) {
        return redirect()->route('admin.dashboard');
    }
    
    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Dashboard para usuários comuns
Route::get('/user/dashboard', [UserDashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('user.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rotas administrativas
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // CRUD de Posts
    Route::resource('posts', PostController::class);
    
    // CRUD de Categorias
    Route::resource('categories', CategoryController::class);
    
    // CRUD de Tags
    Route::resource('tags', TagController::class);
    
    // Gerenciamento de comentários
    Route::patch('comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    Route::patch('comments/{comment}/reject', [CommentController::class, 'reject'])->name('comments.reject');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

require __DIR__.'/auth.php';

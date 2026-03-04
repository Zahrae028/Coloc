<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::delete('/colocation/{colocation}/member/{user}', [ColocationController::class, 'removeMember'])
        ->name('colocation.removeMember');

    Route::post('/colocation/{colocation}/transfer-ownership', [ColocationController::class, 'transferOwnership'])
        ->name('colocation.transferOwnership');

     Route::get('/invitations/create', [InvitationController::class, 'create'])->name('invitations.create');
    Route::post('/invitations', [InvitationController::class, 'store'])->name('invitations.store');

     Route::post('/invitations/{token}/accept', [InvitationController::class, 'accept'])->name('invitations.accept');
    Route::delete('/invitations/{token}/refuse', [InvitationController::class, 'refuse'])->name('invitations.refuse');
    
    Route::get('/invitations', [InvitationController::class, 'index'])->name('invitations.index');
    Route::get('category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('category', [CategoryController::class, 'store'])->name('category.store');
    Route::get('category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('category/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
    
    Route::get('expense', [ExpenseController::class, 'index'])->name('expense.index');
    Route::get('expense/create', [ExpenseController::class, 'create'])->name('expense.create');
    Route::post('expense', [ExpenseController::class, 'store'])->name('expense.store');
    Route::get('expense/{id}/edit', [ExpenseController::class, 'edit'])->name('expense.edit');
    Route::put('expense/{id}', [ExpenseController::class, 'update'])->name('expense.update');
    Route::delete('expense/{id}', [ExpenseController::class, 'destroy'])->name('expense.destroy');
    Route::post('expenses/{expense}/mark-paid/{member}', [ExpenseController::class, 'markPaid'])
        ->name('expenses.markPaid');
});

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/colocations', [AdminController::class, 'colocations'])->name('admin.colocations');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.destroy');
    Route::delete('/colocations/{id}', [AdminController::class, 'deleteColocation'])->name('admin.colocations.destroy');
    
});

Route::get('/home', [ColocationController::class, 'index'])
    ->middleware('auth')
    ->name('home');



Route::get('colocation', [ColocationController::class, 'index'])->name('colocation.index');
Route::get('colocation/create', [ColocationController::class, 'create'])->name('colocation.create');
Route::get('colocation', [ColocationController::class, 'show'])->name('colocation.show');
Route::post('colocation', [ColocationController::class, 'store'])->name('colocation.store');
Route::get('colocation/{id}/edit', [ColocationController::class, 'edit'])->name('colocation.edit');
Route::put('colocation/{id}', [ColocationController::class, 'update'])->name('colocation.update');
Route::delete('colocation/{id}', [ColocationController::class, 'destroy'])->name('colocation.destroy');



require __DIR__ . '/auth.php';

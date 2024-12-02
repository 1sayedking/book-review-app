<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AcountController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;


// Route::prefix('account/')->controller(AcountController::class)->group( function(){
//     // route group with prefix and controller
    
//     // Routes for guests (not authenticated)
//     Route::group(['middleware'=>'guest'], function(){
         
//         Route::get('register','register')->name('account.register');// show register page
//         Route::post('register','processRegister')->name('account.processRegister');// register user
//         Route::get('login','login')->name('account.login'); // Show login page
//         Route::post('login','authenticate')->name('account.authenticate'); // Login user
//     });

//     // Routes for authenticated users
//     Route::group(['middleware'=>'auth'], function(){
        
//         Route::get('profile', 'profile')->name('account.profile'); 
//         Route::post('update-profile','updateProfile')->name('account.updateProfile');
//         Route::get('logout','logout')->name('account.logout');
//     });
// });

//..............................................................................

Route::get('/',[HomeController::class, 'index'])->name('home');

Route::get('read-book/{id}', [BookController::class, 'readBook'])->name('read-book');
Route::get('/book/{id}',[HomeController::class, 'detail'])->name('book.detail');
Route::post('/save-book-review', [HomeController::class, 'saveReview'])->name('book.saveReview')->middleware('auth');

// Password Reset
Route::get('forgot-password', function () {
    return view('account.password.forgot-password');
           })->name('account.forgotPasswordForm');
    Route::prefix('password')->group(function () {
    Route::post('forgot', [AcountController::class, 'sendPasswordResetEmail'])->name('account.forgotPassword');
    Route::get('reset/{token}', [AcountController::class, 'showResetPasswordForm'])->name('account.resetPassword');
    Route::post('reset', [AcountController::class, 'resetPassword'])->name('account.saveResetPassword');
});



Route::group(['prefix'=>'account'], function(){//route  group with prefix

    // Routes for guests (not authenticated)
    Route::group(['middleware'=>'guest'], function(){
        Route::get('register',[AcountController::class, 'register'])->name('account.register');// show register page
        Route::post('register',[AcountController::class, 'processRegister'])->name('account.processRegister');// register user
        Route::get('login', [AcountController::class, 'login'])->name('account.login'); // Show login page
        Route::post('login', [AcountController::class, 'authenticate'])->name('account.authenticate'); // Login user
    
    });

    // Routes for authenticated users
    Route::group(['middleware'=>'auth'], function(){
        Route::get('profile', [AcountController::class, 'profile'])->name('account.profile'); // Show login page
        Route::post('update-profile',[AcountController::class,'updateProfile'])->name('account.updateProfile');
        Route::get('logout',[AcountController::class,'logout'])->name('account.logout');

        // Change Password
        Route::view('change-password', 'account.password.change-password')->name('account.password.changePassword');
        Route::post('change-password', [AcountController::class, 'changePassword'])->name('account.password.savechangePassword');

       
        
        Route::group(['middleware'=>'check-admin'],function(){
            Route::get('books', [BookController::class, 'index'])->name('books.index');
            Route::get('books/create',[BookController::class, 'create'])->name('books.create');
            Route::post('books',[BookController::class, 'store'])->name('books.store');
            Route::get('/download/{id}', [BookController::class, 'download'])->name('download');
            Route::get('books/edit/{id}',[BookController::class, 'edit'])->name('books.edit');
            Route::put('books/update/{id}',[BookController::class, 'update'])->name('books.update');
            Route::delete('books/delete/{id}',[BookController::class, 'destroy'])->name('books.destroy');
             
            Route::get('reviews',[ReviewController::class, 'index'])->name('account.reviews');
            Route::get('reviews/{id}', [ReviewController::class, 'edit'])->name('account.reviews.edit');
            Route::put('reviews/{id}', [ReviewController::class, 'updateReview'])->name('account.reviews.updateReview');
            Route::delete('delete-review/{id}', [ReviewController::class, 'deleteReview'])->name('account.reviews.deleteReview');
        });
        


        Route::get('my-review',[AcountController::class, 'myReviews'])->name('account.myReview');
        Route::get('my-review-ed/{id}',[AcountController::class, 'editReviw'])->name('account.myReviews.editReview');
        Route::put('my-review-up/{id}', [AcountController::class, 'updateReview'])->name('account.myReviews.updateReview');
        Route::delete('my-review-delete/{id}', [AcountController::class, 'deleteReview'])->name('account.myReview.deleteReview');

    });
    
});

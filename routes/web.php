<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PlaceController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', [AuthController::class, 'redirectToLogin']);

Route::group(['prefix' => 'management'], function(){
    Route::group(['prefix' => 'master'], function(){
        // This Route For User Has Logged in/Register, user/adminlocal dashboard and superadmin are different
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('checkLogin');
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('checkLogin');

        // This is middleware/restricted access & checking is the user has role superadmin or not 
        Route::middleware(['IsSuperAdmin'])->group(function(){
            // This is administrator Menu to Manage Users of all 
            Route::group(['prefix' => 'users'], function(){
                Route::get('/', [UsersController::class, 'index'])->name('users');
                Route::get('/blocked', [UsersController::class, 'indexBlocked'])->name('users.blocked');
                Route::get('/pending-approval', [UsersController::class, 'pendingApproval'])->name('users.pending');
    
                Route::post('/store', [UsersController::class, 'store'])->name('users.store');
                Route::put('/update', [UsersController::class, 'update'])->name('users.update');
                Route::put('/{id}/approve', [UsersController::class, 'approve'])->name('users.approve');
                Route::put('/{id}/unapprove', [UsersController::class, 'unapprove'])->name('users.unapprove');
                Route::put('/{id}/block', [UsersController::class, 'block'])->name('users.block');
                Route::put('/{id}/unblock', [UsersController::class, 'unblock'])->name('users.unblock');
                Route::get('/detail/{id}', [UsersController::class, 'getUserDetail'])->name('users.detail');
            });

            // This is administrator Menu to Manage Place of all 
            Route::group(['prefix' => 'place'], function(){
                Route::get('/', [PlaceController::class, 'index'])->name('place');
                Route::get('/edit/{place_code}', [PlaceController::class, 'editPlace'])->name('place.edit');
                Route::get('/deleted-place', [PlaceController::class, 'indexDeletedPlace'])->name('place.getDeleted');
                Route::get('/create', [PlaceController::class, 'indexCreatePlace'])->name('place.create');
                Route::delete('{place_code}/delete', [PlaceController::class, 'deletePlace'])->name('place.delete');
            });

            Route::group(['prefix' => 'event'], function(){
                Route::get('/', [EventController::class, 'indexAdmin'])->name('event');
                Route::post('/store-admin', [EventController::class, 'adminStore'])->name('event.adminStore');
            });
        });
        
        //Create Middleware For User Has Logged In
        Route::middleware(['checkLogin'])->group(function(){
            Route::get('/print-barcode/{placeCode}', [PlaceController::class, 'print'])->name('place.print');
            
            Route::get('/my-place', [PlaceController::class, 'returnMyPlaceView'])->name('place.myplace');
            Route::post('/my-place/update', [PlaceController::class, 'updatePlace'])->name('place.update');
            Route::post('/store', [PlaceController::class, 'store'])->name('place.store');
            Route::get('/get-detail-data/{code}', [PlaceController::class, 'getDetailPlaceData'])->name('place.getDetailPlaceData');

            Route::get('/profile', [UsersController::class, 'viewProfile'])->name('profile');
            Route::post('/profile/update', [UsersController::class, 'updateProfile'])->name('profile.update');

            Route::group(['prefix' => 'my-event'], function(){
                Route::get('/', [EventController::class, 'index'])->name('myevent.users');
                Route::get('/get-data/{id}', [EventController::class, 'getData'])->name('myevent.getData');
                Route::post('/store', [EventController::class, 'store'])->name('myevent.store');
                Route::post('/update', [EventController::class, 'update'])->name('myevent.update');
                Route::post('/delete/{id}', [EventController::class, 'delete'])->name('myevent.delete');
            });
        });
    });

});

// This is for public user when the user wan't to Login/Register
Route::group(['prefix' => 'auth'], function(){
    Route::get('/login', [AuthController::class, 'viewLogin'])->name('login');
    Route::post('/login/store', [AuthController::class, 'store'])->name('login.store');
    Route::get('/register', [AuthController::class, 'viewRegister'])->name('register');
    Route::post('/register/store', [AuthController::class, 'storeRegister'])->name('register.store');
});

// This is Public Route For Anonym Users
Route::get('/detail-place/{place_code}', [PlaceController::class, 'getDetailPlace'])->name('place.detail');

Route::get('/terms-of-service', [DashboardController::class, 'termsOfService'])->name('termsOfService');
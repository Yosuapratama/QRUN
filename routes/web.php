<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\PlaceLimitController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UsersHasLimitController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'redirectToLogin']);

Route::get('/sync', [DashboardController::class, 'sync']);

Route::group(['prefix' => 'management'], function(){
    Route::group(['prefix' => 'master'], function(){
        // This Route For User Has Logged in/Register, user/adminlocal dashboard and superadmin are different
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('checkLogin');
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('checkLogin');

    
        // This is middleware/restricted access & checking is the user has role superadmin or not 
        Route::middleware(['IsSuperAdmin'])->group(function(){
            // This is administrator Menu to Manage Users of all 
            Route::get('/dashboard/data/chart', [DashboardController::class, 'getChartData'])->name('chart.data');

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

            Route::group(['prefix' => 'users-limit'], function(){
                Route::get('/', [UsersHasLimitController::class, 'index'])->name('users-limit.index');
                Route::get('/fetchData', [UsersHasLimitController::class, 'getUserHasLimit'])->name('users-limit.fetch');
                Route::post('/store', [UsersHasLimitController::class, 'store'])->name('users-limit.store');
                Route::post('/update', [UsersHasLimitController::class, 'update'])->name('users-limit.update');
                Route::post('/{id}/delete', [UsersHasLimitController::class, 'delete'])->name('users-limit.delete');
                Route::get('/{id}/get', [UsersHasLimitController::class, 'fetchData'])->name('users-limit.getData');
            });

            // This is administrator Menu to Manage Place of all 
            Route::prefix('place-limit')->group(function () {
                Route::get('/', [PlaceLimitController::class, 'index'])->name('place-limit.index');
                Route::get('/create', [PlaceLimitController::class, 'create'])->name('place-limit.create');
                Route::post('/store', [PlaceLimitController::class, 'store'])->name('place-limit.store');
                Route::get('/{id}/edit', [PlaceLimitController::class, 'edit'])->name('place-limit.edit');
                Route::post('/{id}/update', [PlaceLimitController::class, 'update'])->name('place-limit.update');
                Route::delete('/{id}/delete', [PlaceLimitController::class, 'destroy'])->name('place-limit.destroy');
            });
            
            Route::prefix('pending-verify')->group(function(){
                Route::get('/', [UsersController::class, 'pendingVerify'])->name('pending-verify.index');
                Route::post('/{id}/verify', [UsersController::class, 'verifyAccountManual'])->name('pending-verify.verify');
            });

            Route::group(['prefix' => 'settings'], function(){
                Route::get('/general', [SettingsController::class, 'generalIndex'])->name('settings.general');
                Route::get('/general/artisan/optimize', function(){
                    Artisan::call('optimize');
                    
                    return back();
                })->name('artisan.optimize');
                Route::get('/general/artisan/queue', function(){
                    Artisan::call('queue:restart');
                    
                    return back();
                })->name('artisan.queue');

            });
        });
        
        Route::middleware(['checkUserLimitPermissions'])->group(function(){
            Route::group(['prefix' => 'place'], function(){
                Route::get('/', [PlaceController::class, 'index'])->name('place');
                Route::get('/edit/{place_code}', [PlaceController::class, 'editPlace'])->name('place.edit');
                Route::get('/deleted-place', [PlaceController::class, 'indexDeletedPlace'])->name('place.getDeleted');
                Route::get('/create', [PlaceController::class, 'indexCreatePlace'])->name('place.create');
                Route::delete('{place_code}/delete', [PlaceController::class, 'deletePlace'])->name('place.delete');
    
                Route::get('/fetchall', [PlaceController::class, 'fetchAll'])->name('place.getAll');
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

            Route::group(['prefix' => 'comments'], function(){
                Route::get('/', [CommentController::class, 'datatable'])->name('comments.admin');
                Route::delete('/{id}/delete', [CommentController::class, 'delete'])->name('comments.delete');
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
Route::get('/detail-place/{place_code}/comments', [CommentController::class, 'index'])->name('comments.index');
Route::post('/detail-place/{place_code}/comments/store', [CommentController::class, 'store'])->name('comments.storeco');

Route::get('/terms-of-service', [DashboardController::class, 'termsOfService'])->name('termsOfService');

Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyMail'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', [AuthController::class, 'resendMailVerification'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');

Route::post('/forgot-password', [AuthController::class, 'submitForgotPassword'])->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'resetPassView'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'updatePassword'])->middleware('guest')->name('password.update');
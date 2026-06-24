<?php

use App\Http\Controllers\AdvertiseController;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthGoogleController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EbookController;
use App\Http\Controllers\EbookAssignmentController;
use App\Http\Controllers\EbookCategoryController;
use App\Http\Controllers\EbookPlaceController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\LogActivitiesController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\PlaceLimitController;
use App\Http\Controllers\HistoryScanController;
use App\Http\Controllers\PlaceLimitRequestController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UsersHasLimitController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/sitemap.xml', function () {
    return response(
        File::get(public_path('sitemap.xml')),
        200,
        ['Content-Type' => 'application/xml']
    );
});


Route::get('/', [AuthController::class, 'redirectToLogin'])->name('homes');
Route::get('/contact', [AuthController::class, 'contactPage'])->name('contact');
Route::get('/blog', [AuthController::class, 'blogPage'])->name('blog');
Route::get('/blog/{slug}', [AuthController::class, 'detailBlog'])->name('blog.detail');

// Route::get('/ebook', [AuthController::class, 'ebookPage'])->name('ebook');
Route::get('/ebook/{slug}', [AuthController::class, 'detailEbook'])->name('ebook.detail');

// Public: visitor scans a location QR to browse its ebooks
Route::get('/ebook-place/{code}', [EbookPlaceController::class, 'scan'])->name('ebook-place.scan');
Route::get('/ebook-place/{code}/ebooks', [EbookPlaceController::class, 'scanData'])->name('ebook-place.scan.data');

// Public: server-side read-gating (unlock a locked ebook). CSRF protected.
Route::post('/ebook-place/{code}/unlock/start', [EbookPlaceController::class, 'unlockStart'])->name('ebook-place.unlock.start');
Route::post('/ebook-place/{code}/unlock/complete', [EbookPlaceController::class, 'unlockComplete'])->name('ebook-place.unlock.complete');
Route::post('/ebook-place/{code}/unlock/review', [EbookPlaceController::class, 'unlockReview'])->name('ebook-place.unlock.review');

Route::get('/blog-ajax/search', [AuthController::class, 'search'])->name('blog.search');
Route::get('/blog-ajax/load-more', [AuthController::class, 'loadMore'])->name('blog.loadMore');

Route::get('/gallery/ajax-list', [GalleryController::class, 'ajaxList'])->name('gallery.ajax-list');

Route::get('/sync', [DashboardController::class, 'sync']);

Route::get('set-locale/{locale}', [DashboardController::class, 'setLocale'])->name('set.locale');

Route::group(['prefix' => 'management'], function () {
    Route::group(['prefix' => 'master'], function () {
        Route::middleware(['checkLogin'])->group(function () {

            Route::get('/sync/migration', function () {
                Artisan::call('migration:sync');
                return back()->with('success', 'Migration status synced successfully!');
            })->name('migration.sync');

            // Run pending migrations from the browser (shared hosting without CLI).
            // Superadmin only; --force so it runs in production without a prompt.
            Route::get('/sync/migrate', function () {
                if (!auth()->check() || !auth()->user()->hasRole('superadmin')) {
                    abort(403);
                }
                Artisan::call('migrate', ['--force' => true]);
                return response('<pre style="font-family:monospace;padding:16px;">'
                    . e(Artisan::output()) . '</pre>');
            })->name('migrate.run');

            Route::get('/sync/advertise', function () {
                Artisan::call('advertise:sync-images');
                return back()->with('success', 'Advertise images synced successfully!');
            })->name('advertise.sync');

            Route::get(
                '/report/excel/place',
                [PlaceController::class, 'reportExcelPlace']
            )->name('report.excel.place');

            Route::get('/dashboard/map-data', [DashboardController::class, 'getMapData'])->name('dashboard.map-data');
            Route::get('/dashboard/stats', [DashboardController::class, 'getDashboardStats'])->name('dashboard.stats');
            // This Route For User Has Logged in/Register, user/adminlocal dashboard and superadmin are different

            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('checkLogin');
            Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('checkLogin');
            Route::get(
                '/dashboard/running-scan-time',
                [DashboardController::class, 'getRunningScanTimeNow']
            )->name('dashboard.running-scan-time');
            Route::post('/dashboard/send-recap-today', [DashboardController::class, 'sendRecapToday'])->name('dashboard.send-recap-today');
            // This is administrator Menu to Manage Users of all 
            Route::get('/dashboard/data/chart', [DashboardController::class, 'getChartData'])->name('chart.data');
        });

        // This is middleware/restricted access & checking is the user has role superadmin or not 
        Route::middleware(['IsSuperAdmin'])->group(function () {
            Route::get('/dashboard/data/user-growth/chart', [DashboardController::class, 'userGrowth'])->name('chart.userGrowth');

            Route::group(['prefix' => 'users'], function () {
                Route::get('/', [UsersController::class, 'index'])->name('users');
                // Route::get('/blocked', [UsersController::class, 'indexBlocked'])->name('users.blocked');
                // Route::get('/pending-approval', [UsersController::class, 'pendingApproval'])->name('users.pending');

                Route::post('/store', [UsersController::class, 'store'])->name('users.store');
                Route::put('/update', [UsersController::class, 'update'])->name('users.update');
                Route::put('/{id}/approve', [UsersController::class, 'approve'])->name('users.approve');
                Route::put('/{id}/unapprove', [UsersController::class, 'unapprove'])->name('users.unapprove');
                Route::put('/{id}/block', [UsersController::class, 'block'])->name('users.block');
                Route::put('/{id}/unblock', [UsersController::class, 'unblock'])->name('users.unblock');
                Route::get('/detail/{id}', [UsersController::class, 'getUserDetail'])->name('users.detail');
            });

            Route::group(['prefix' => 'users-limit'], function () {
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

            Route::prefix('place-limit-request')->group(function () {
                Route::get('/', [PlaceLimitRequestController::class, 'index'])->name('place-limit-request.index');
                Route::post('/{id}/approve', [PlaceLimitRequestController::class, 'approve'])->name('place-limit-request.approve');
                Route::post('/{id}/reject', [PlaceLimitRequestController::class, 'reject'])->name('place-limit-request.reject');
            });


            Route::prefix('pending-verify')->group(function () {
                Route::get('/', [UsersController::class, 'pendingVerify'])->name('pending-verify.index');
                Route::post('/{id}/verify', [UsersController::class, 'verifyAccountManual'])->name('pending-verify.verify');
            });

            Route::prefix('advertise')->group(function () {
                Route::get('/', [AdvertiseController::class, 'index'])->name('advertise.index');
                Route::get('/create', [AdvertiseController::class, 'create'])->name('advertise.create');
                Route::post('/store', [AdvertiseController::class, 'storeOrUpdate'])->name('advertise.storeOrUpdate');
                Route::get('/{id}/edit', [AdvertiseController::class, 'edit'])->name('advertise.edit');
                Route::delete('/{id}/delete', [AdvertiseController::class, 'destroy'])->name('advertise.destroy');
            });

            Route::prefix('gallery')->group(function () {
                Route::get('/', [GalleryController::class, 'index'])->name('gallery.index');
                Route::get('/create', [GalleryController::class, 'create'])->name('gallery.create');
                Route::post('/store', [GalleryController::class, 'storeOrUpdate'])->name('gallery.storeOrUpdate');
                Route::get('/{id}/edit', [GalleryController::class, 'edit'])->name('gallery.edit');
                Route::post('/{id}/toggle-status', [GalleryController::class, 'toggleStatus'])->name('gallery.toggle-status');
                Route::delete('/{id}/delete', [GalleryController::class, 'destroy'])->name('gallery.destroy');
            });

            Route::prefix('report')->group(function () {
                Route::get('/', [ReportController::class, 'index'])->name('report.index');
                Route::get('/create', [ReportController::class, 'create'])->name('report.create');
                Route::post('/store', [ReportController::class, 'storeOrUpdate'])->name('report.storeOrUpdate');
                Route::get('/pdf', [ReportController::class, 'reportPdf'])->name('report.pdf');
                Route::get('/{id}/edit', [ReportController::class, 'edit'])->name('report.edit');
                // Route::post('/{id}/toggle-status', [ReportController::class, 'toggleStatus'])->name('report.toggle-status');
                Route::delete('/{id}/delete', [ReportController::class, 'destroy'])->name('report.destroy');

                Route::get('/places', [ReportController::class, 'getPlaces'])->name('report.places');
                Route::get('/users', [ReportController::class, 'getUsers'])->name('report.users');
                Route::get('/events', [ReportController::class, 'getEvents'])->name('report.events');
            });

            Route::prefix('blog')->group(function () {
                Route::get('/', [BlogController::class, 'index'])->name('blog.index');
                Route::get('/create', [BlogController::class, 'create'])->name('blog.create');
                Route::post('/store', [BlogController::class, 'store'])->name('blog.store');
                Route::get('/{id}/edit', [BlogController::class, 'edit'])->name('blog.edit');
                Route::post('/update', [BlogController::class, 'update'])->name('blog.update');
                Route::delete('/{id}/delete', [BlogController::class, 'destroy'])->name('blog.destroy');
            });

            Route::prefix('ebook')->group(function () {
                Route::get('/', [EbookController::class, 'index'])->name('ebook.index');
                Route::get('/create', [EbookController::class, 'create'])->name('ebook.create');
                Route::post('/store', [EbookController::class, 'store'])->name('ebook.store');
                Route::get('/{id}/edit', [EbookController::class, 'edit'])->name('ebook.edit');
                Route::get('/{id}/detail', [EbookController::class, 'show'])->name('ebook.detail');
                Route::get('/{id}/reviews/export/preview', [EbookController::class, 'reviewsExportPreview'])->name('ebook.reviews.preview');
                Route::get('/{id}/reviews/export', [EbookController::class, 'reviewsExport'])->name('ebook.reviews.export');
                Route::post('/update', [EbookController::class, 'update'])->name('ebook.update');
                Route::delete('/{id}/delete', [EbookController::class, 'destroy'])->name('ebook.destroy');
            });

            Route::prefix('ebook-place')->group(function () {
                Route::get('/', [EbookPlaceController::class, 'index'])->name('ebook-place.index');
                Route::get('/create', [EbookPlaceController::class, 'create'])->name('ebook-place.create');
                Route::post('/store', [EbookPlaceController::class, 'store'])->name('ebook-place.store');
                Route::get('/{id}/detail', [EbookPlaceController::class, 'show'])->name('ebook-place.detail');
                Route::get('/{id}/connected-ebooks', [EbookPlaceController::class, 'connectedEbooks'])->name('ebook-place.connected');
                Route::get('/{id}/reviews/export/preview', [EbookPlaceController::class, 'reviewsExportPreview'])->name('ebook-place.reviews.preview');
                Route::get('/{id}/reviews/export', [EbookPlaceController::class, 'reviewsExport'])->name('ebook-place.reviews.export');
                Route::get('/{id}/edit', [EbookPlaceController::class, 'edit'])->name('ebook-place.edit');
                Route::post('/update', [EbookPlaceController::class, 'update'])->name('ebook-place.update');
                Route::delete('/{id}/delete', [EbookPlaceController::class, 'destroy'])->name('ebook-place.destroy');
                Route::get('/{code}/print', [EbookPlaceController::class, 'print'])->name('ebook-place.print');
            });

            Route::prefix('ebook-category')->group(function () {
                Route::get('/', [EbookCategoryController::class, 'index'])->name('ebook-category.index');
                Route::post('/store', [EbookCategoryController::class, 'store'])->name('ebook-category.store');
                Route::post('/update', [EbookCategoryController::class, 'update'])->name('ebook-category.update');
                Route::delete('/{id}/delete', [EbookCategoryController::class, 'destroy'])->name('ebook-category.destroy');
            });

            Route::prefix('ebook-assignment')->group(function () {
                Route::get('/', [EbookAssignmentController::class, 'index'])->name('ebook-assignment.index');
                Route::get('/{id}/ebooks', [EbookAssignmentController::class, 'show'])->name('ebook-assignment.show');
                Route::post('/store', [EbookAssignmentController::class, 'store'])->name('ebook-assignment.store');
            });

            Route::group(['prefix' => 'settings'], function () {
                Route::get('/general', [SettingsController::class, 'generalIndex'])->name('settings.general');
                Route::post('/general/store', [SettingsController::class, 'store'])->name('settings.store');
                Route::get('/general/artisan/optimize', function () {
                    Artisan::call('optimize');

                    return back()->withSuccess('Application optimized successfully.');
                })->name('artisan.optimize');
                Route::get('/general/artisan/queue', function () {
                    Artisan::call('queue:restart');

                    return back()->withSuccess('Queue restarted successfully.');
                })->name('artisan.queue');

                Route::get('/log-activity', [LogActivitiesController::class, 'index'])->name('settings.log-activity');
            });

            Route::post('/file/upload/ads', [FileController::class, 'uploadImageAds'])->name('upload.ads');
            Route::post('/file/upload/gallery', [FileController::class, 'uploadImageGallery'])->name('upload.gallery');
            Route::post('/file/upload/blog', [FileController::class, 'uploadImageBlog'])->name('upload.blog');
            Route::post('/file/upload/ebook', [FileController::class, 'uploadImageEbook'])->name('upload.ebook');
            Route::post('/file/upload/place/ads', [FileController::class, 'uploadImageAdsPlace'])->name('upload.place.ads');
            Route::post('/file/upload/ads/bulk', [FileController::class, 'bulkUploadImageAds'])->name('upload.ads.bulk');
        });

        Route::middleware(['checkUserLimitPermissions'])->group(function () {

            Route::group(['prefix' => 'place'], function () {

                Route::prefix('history-scan')->group(function () {
                    Route::get('/', [HistoryScanController::class, 'index'])->name('history-scan.index');
                    Route::get('/export', [HistoryScanController::class, 'export'])->name('history-scan.export');
                });
                
                Route::get('/', [PlaceController::class, 'index'])->name('place');
                Route::get('/edit/{place_code}', [PlaceController::class, 'editPlace'])->name('place.edit');
                Route::get('/detail/{place_code}', [PlaceController::class, 'show'])->name('place.detail');
                Route::get('/deleted-place', [PlaceController::class, 'indexDeletedPlace'])->name('place.getDeleted');
                Route::get('/create', [PlaceController::class, 'indexCreatePlace'])->name('place.create');
                Route::delete('{place_code}/delete', [PlaceController::class, 'deletePlace'])->name('place.delete');
                Route::post('/{id}/restore', [PlaceController::class, 'restorePlace'])->name('place.restore');

                Route::get('/chart-data', [PlaceController::class, 'getPlaceChartData'])->name('place.chart-data');


                // AJAX Search endpoints for cascading location filters
                Route::get('/search/provinces', [PlaceController::class, 'searchProvinces'])->name('place.search.provinces');
                Route::get('/search/regencies', [PlaceController::class, 'searchRegencies'])->name('place.search.regencies');
                Route::get('/search/districts', [PlaceController::class, 'searchDistricts'])->name('place.search.districts');
                Route::get('/search/villages', [PlaceController::class, 'searchVillages'])->name('place.search.villages');
            });
        });
        //Create Middleware For User Has Logged In
        Route::middleware(['checkLogin'])->group(function () {
            Route::group(['prefix' => 'event'], function () {
                Route::get('/', [EventController::class, 'indexAdmin'])->name('event');
                Route::post('/store-admin', [EventController::class, 'adminStore'])->name('event.adminStore');
            });

            Route::get('/fetchall', [PlaceController::class, 'fetchAll'])->name('place.getAll');
            Route::get('/print-barcode/{placeCode}', [PlaceController::class, 'print'])->name('place.print');

            Route::get('/my-place', [PlaceController::class, 'returnMyPlaceView'])->name('place.myplace');
            Route::post('/my-place/update', [PlaceController::class, 'updatePlace'])->name('place.update');

            Route::prefix('my-history-scan')->group(function () {
                Route::get('/', [HistoryScanController::class, 'myIndex'])->name('history-scan.my');
                Route::get('/export', [HistoryScanController::class, 'myExport'])->name('history-scan.my-export');
            });
            Route::post('/store', [PlaceController::class, 'store'])->name('place.store');
            Route::get('/get-detail-data/{code}', [PlaceController::class, 'getDetailPlaceData'])->name('place.getDetailPlaceData');

            Route::get('/profile', [UsersController::class, 'viewProfile'])->name('profile');
            Route::post('/profile/update', [UsersController::class, 'updateProfile'])->name('profile.update');

            Route::group(['prefix' => 'my-event'], function () {
                Route::get('/', [EventController::class, 'index'])->name('myevent.users');
                Route::get('/get-data/{id}', [EventController::class, 'getData'])->name('myevent.getData');
                Route::post('/store', [EventController::class, 'store'])->name('myevent.store');
                Route::post('/update', [EventController::class, 'update'])->name('myevent.update');
                Route::post('/delete/{id}', [EventController::class, 'delete'])->name('myevent.delete');
            });

            Route::group(['prefix' => 'comments'], function () {
                Route::get('/', [CommentController::class, 'datatable'])->name('comments.admin');
                Route::delete('/{id}/delete', [CommentController::class, 'delete'])->name('comments.delete');
            });

            Route::post('/file/upload', [FileController::class, 'uploadFile'])->name('file.upload');
            Route::get('getlocationdata', [DashboardController::class, 'getLocation'])->name('getLocation');

            Route::post('/place-limit-request/store', [PlaceLimitRequestController::class, 'store'])->name('place-limit-request.store');
            Route::get('/place-limit-request/check-pending', [PlaceLimitRequestController::class, 'checkPending'])->name('place-limit-request.check-pending');
        });
    });
});

// This Auth google
Route::get('/auth/google', [AuthGoogleController::class, 'authGoogle'])->name('authGoogle');
Route::get('/auth/google/callback', [AuthGoogleController::class, 'googleCallback'])->name('callbackUrl');
// Route::get('/auth/google/callback', function(){
//     return 'wkwk';
// });
// This is for public user when the user wan't to Login/Register
Route::group(['prefix' => 'auth'], function () {
    Route::get('/login', [AuthController::class, 'viewLogin'])->name('login');
    Route::post('/login/store', [AuthController::class, 'store'])->name('login.store');
    Route::get('/register', [AuthController::class, 'viewRegister'])->name('register');
    Route::post('/register/store', [AuthController::class, 'storeRegister'])->name('register.store');
});

// This is Public Route For Anonym Users
Route::get('/detail-place/{place_code}', [PlaceController::class, 'getDetailPlace'])->name('place.detailGlobal');
Route::get('/detail-place/{place_code}/comments', [CommentController::class, 'index'])->name('comments.index');
Route::post('/detail-place/{place_code}/comments/store', [CommentController::class, 'store'])->name('comments.storeco');
Route::post('/detail-place/{place_code}/comments/{commentId}/delete', [CommentController::class, 'deleteCommentsByUser'])->middleware('checkLogin');
Route::post('/detail-place/{place_code}/comments/update', [CommentController::class, 'updateComment'])->middleware('checkLogin');

Route::get('/terms-of-service', [DashboardController::class, 'termsOfService'])->name('termsOfService');
Route::get('/privacy-policy', [DashboardController::class, 'privacyPolicy'])->name('privacyPolicy');

Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyMail'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', [AuthController::class, 'resendMailVerification'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');

Route::post('/forgot-password', [AuthController::class, 'submitForgotPassword'])->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'resetPassView'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'updatePassword'])->middleware('guest')->name('password.update');

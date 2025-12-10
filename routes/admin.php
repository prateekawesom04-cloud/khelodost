<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ApiCallController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDataController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SportbookController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\EventController;




// Admin routes

Route::middleware(['admin_auth_middleware'])->group(function () {

    Route::prefix('admin')->group(function () {

        Route::get('/login', function () {
            return view('admin.pages.login');
        })->name('admin.login');
        
        Route::post('login', [AdminAuthController::class,'login'])->name('admin.auth.login');

    });

});

Route::middleware(['admin_auth_check_middleware','custom_admin_session_middleware'])->group(function () {
    
    Route::prefix('admin')->group(function () {
        
        Route::get('/logout', function () {
            Session::flush();
            return redirect()->route('admin.login');
        })->name('admin.logout');

        Route::get('/', [AdminDataController::class,'index'])->name('admin.index');
        
        Route::get('bonusData', [AdminDataController::class,'bonusData'])->name('admin.bonusData');

        Route::post('/createBonus', [AdminDataController::class,'createBonus'])->name('admin.action.createBonus')->withoutMiddleware([VerifyCsrfToken::class]);
        
        Route::post('/assignBonus', [AdminDataController::class,'assignBonus'])->name('admin.action.assignBonus')->withoutMiddleware([VerifyCsrfToken::class]);
        
        Route::post('updateBonus', [AdminDataController::class,'updateBonus'])->name('admin.action.updateBonus')->withoutMiddleware([VerifyCsrfToken::class]);

        Route::post('changeBonusStatus', [AdminDataController::class,'changeBonusStatus'])->name('admin.action.changeBonusStatus')->withoutMiddleware([VerifyCsrfToken::class]);

        Route::get('/user_downline_list/{username}', [AdminUserController::class,'user_downline_list'])->name('admin.user_downline_list');
        
        // Route::get('/user_downline_list', [AdminUserController::class,'user_downline_list'])->name('admin.user_downline_list');
        
        Route::post('/blockUser', [AdminUserController::class,'blockUser'])->name('admin.action.blockUser')->withoutMiddleware([VerifyCsrfToken::class]);
        
        Route::post('/add_user_client', [AdminUserController::class,'add_user_client'])->name('admin.action.add_user_client');
        
        Route::post('/updateUserPhone', [AdminUserController::class,'updateUserPhone'])->name('admin.action.updateUserPhone');
        
        Route::post('/updateUserPassword', [AdminUserController::class,'updateUserPassword'])->name('admin.action.updateUserPassword');
        
        Route::post('/updateWallet', [AdminUserController::class,'updateWallet'])->name('admin.action.updateWallet');
        
        // Route::post('/updateTransaction', [TransactionController::class,'updateTransaction'])->name('admin.action.updateTransaction')->withoutMiddleware([VerifyCsrfToken::class]);

        Route::post('/updateTransaction', [TransactionController::class,'lgpayUpdateTransaction'])->name('admin.action.updateTransaction')->withoutMiddleware([VerifyCsrfToken::class]);

        Route::get('/inactive_user_downline_list', [AdminDataController::class,'inactive_user_downline_list'])->name('admin.inactive_user_downline_list');

        Route::get('/betlist', [AdminDataController::class,'betlist'])->name('admin.betlist');

        Route::get('/user_client_account', function () {
            return view('admin.pages.user_client_account');
        })->name('admin.user_client_account');

        
        Route::get('/master_downline_list', [AdminUserController::class,'master_downline_list'])->name('admin.master_downline_list');

        Route::get('/add_edit_client_account', function () {
            return view('admin.pages.add_edit_client_account');
        })->name('admin.add_edit_client_account');
        
        Route::get('/my_account/{username}', [AdminUserController::class,'my_account'])->name('admin.my_account');

        Route::get('/event_profit_loss', function () {
        return view('admin.pages.event_profit_loss');
            })->name('admin.event_profit_loss');

        Route::get('/downline_profit_loss', function () {
        return view('admin.pages.downline_profit_loss');
            })->name('admin.downline_profit_loss');


        // Route::get('/betlist', function () {
        // return view('admin.pages.betlist');
        //     })->name('admin.betlist');

        Route::get('/sampleTable', function () {
        return view('admin.pages.sampleTable');
            })->name('admin.sampleTable');

        // Route::get('/market_analysis', function () {
        // return view('admin.pages.market_analysis');
        //     })->name('admin.market_analysis');

        // Route::get('/add_bonus', function () {
        // return view('admin.pages.add_bonus');
        //     })->name('admin.add_bonus');

        Route::get('/add_bonus', [AdminDataController::class,'add_bonus'])->name('admin.add_bonus');
        
        Route::get('/deposit', [AdminDataController::class,'deposit'])->name('admin.deposit');

        Route::get('/withdraw', [AdminDataController::class,'withdraw'])->name('admin.withdraw');

        Route::get('/payments', [AdminDataController::class,'payments'])->name('admin.payments');

        Route::get('/commission', [AdminDataController::class,'commission'])->name('admin.commission');

        Route::get('/news_view', [AdminDataController::class,'news_view'])->name('admin.news_view');

            Route::get('/admin_fund', function () {
        return view('admin.pages.admin_fund');
            })->name('admin.admin_fund');

        // Route::get('/user_general_setting', function () {
        //     return view('admin.pages.user_general_setting');
        //     })->name('admin.user_general_setting');

        Route::get('/user_general_setting', [AdminDataController::class,'user_general_setting'])->name('admin.user_general_setting')->withoutMiddleware([VerifyCsrfToken::class]);
        Route::post('/user_general_setting', [AdminDataController::class,'user_general_setting'])->name('admin.action.user_general_setting')->withoutMiddleware([VerifyCsrfToken::class]);
        
        Route::get('/block_market', [MarketController::class,'block_market'])->name('admin.block_market')->withoutMiddleware([VerifyCsrfToken::class]);
        Route::post('/block_market', [MarketController::class,'marketUpdate'])->name('admin.action.block_market')->withoutMiddleware([VerifyCsrfToken::class]);
        
        //     Route::get('/block_market', function () {
        // return view('admin.pages.block_market');
        //     })->name('admin.block_market');

            Route::get('/event_wise_setting', function () {
        return view('admin.pages.event_wise_setting');
            })->name('admin.event_wise_setting');

            Route::get('/betting', function () {
        return view('admin.pages.betting');
            })->name('admin.betting');

        //     Route::get('/add_banner', function () {
        // return view('admin.pages.add_banner');
        //     })->name('admin.add_banner');
            
        Route::get('/add_banner', [BannerController::class,'add_banner'])->name('admin.add_banner')->withoutMiddleware([VerifyCsrfToken::class]);

        Route::post('/add_banner', [BannerController::class,'addBanner'])->name('admin.action.add_banner')->withoutMiddleware([VerifyCsrfToken::class]);
        
        Route::post('/bannerUpdate', [BannerController::class,'bannerUpdate'])->name('admin.action.bannerUpdate')->withoutMiddleware([VerifyCsrfToken::class]);
        
        Route::post('/bannerUpdateImage', [BannerController::class,'bannerUpdateImage'])->name('admin.action.bannerUpdateImage')->withoutMiddleware([VerifyCsrfToken::class]);
        
        Route::post('/deleteBanner', [BannerController::class,'deleteBanner'])->name('admin.action.deleteBanner')->withoutMiddleware([VerifyCsrfToken::class]);

        Route::post('/eventStatus', [EventController::class,'eventStatus'])->name('admin.action.eventStatus')->withoutMiddleware([VerifyCsrfToken::class]);

        Route::get('/eventDetail/{eventId}', [EventController::class,'eventDetail'])->name('admin.eventDetail')->withoutMiddleware([VerifyCsrfToken::class]);

            Route::get('/add_number', function () {
        return view('admin.pages.add_number');
            })->name('admin.add_number');





            

        // Post/Action requests start

        Route::post('/user_client_account', [AdminDataController::class,'submitForm'])->name('admin.action.user_client_account');
        
        Route::post('/userStatments', [AdminDataController::class,'userStatments'])->name('admin.action.userStatments');
        
        Route::post('/userGameHistory', [AdminDataController::class,'userGameHistory'])->name('admin.action.userGameHistory');

        Route::post('changePassword', [AuthController::class,'changePassword'])->name('changePassword')->withoutMiddleware([VerifyCsrfToken::class]);
        
        Route::post('deleteUser', [AdminDataController::class,'deleteUser'])->name('admin.action.deleteUser')->withoutMiddleware([VerifyCsrfToken::class]);

        Route::post('/submitUserUpdates', [AdminDataController::class,'submitUserUpdates'])->name('admin.action.submitUserUpdates');

        Route::post('/add_edit_client_account', [AdminDataController::class,'submitForm'])->name('admin.action.add_edit_client_account');
        
        Route::post('createModelData', [AdminDataController::class,'createModelData'])->name('createModelData')->withoutMiddleware([VerifyCsrfToken::class]);
        
        Route::post('getModelData', [AdminDataController::class,'getModelData'])->name('getModelData')->withoutMiddleware([VerifyCsrfToken::class]);
        
        Route::post('updateModelData', [AdminDataController::class,'updateModelData'])->name('updateModelData')->withoutMiddleware([VerifyCsrfToken::class]);
        
        Route::post('getDateRangeData', [AdminDataController::class,'getDateRangeData'])->name('getDateRangeData')->withoutMiddleware([VerifyCsrfToken::class]);
        
        Route::post('update_news', [AdminDataController::class,'update_news'])->name('update_news')->withoutMiddleware([VerifyCsrfToken::class]);
        
        Route::post('delete_news', [AdminDataController::class,'delete_news'])->name('delete_news')->withoutMiddleware([VerifyCsrfToken::class]);
        
        Route::post('addFund', [AdminDataController::class,'addFund'])->name('addFund')->withoutMiddleware([VerifyCsrfToken::class]);
        
        Route::post('updatePhone', [AdminDataController::class,'updatePhone'])->name('updatePhone')->withoutMiddleware([VerifyCsrfToken::class]);
        
        Route::post('updateSportResult', [AdminDataController::class,'updateSportResult'])->name('updateSportResult')->withoutMiddleware([VerifyCsrfToken::class]);
        
        Route::get('sattlement/{sport}', [AdminDataController::class,'sattlement'])->name('sattlement');
        
        Route::get('market_analysis', [AdminDataController::class,'market_analysis'])->name('admin.market_analysis');

        Route::get('cricket_analysis', [AdminDataController::class,'cricket_analysis'])->name('admin.cricket_analysis');
        Route::get('soccer_analysis', [AdminDataController::class,'soccer_analysis'])->name('admin.soccer_analysis');
        Route::get('tennis_analysis', [AdminDataController::class,'tennis_analysis'])->name('admin.tennis_analysis');

        Route::post('sattleEvent', [AdminDataController::class,'sattleEvent'])->name('sattleEvent')->withoutMiddleware([VerifyCsrfToken::class]);

        Route::post('sattleEventBets', [AdminDataController::class,'sattleEventBets'])->name('admin.sattleEventBets')->withoutMiddleware([VerifyCsrfToken::class]);
            

        // Route::get('/sattlement', function () {
        //     return view('pages.sattlement');
        // })->name('sattlement');
    });
    
        // Post/Action requests end


});


// Routes with no middleware

Route::get('getSportFixture/{sportname}',[SportbookController::class,'getSportFixture'])->name('getSportFixture');
Route::get('getCricketEventData/{eventId}',[SportbookController::class,'getCricketEventData'])->name('getCricketEventData');
Route::post('updateSportResult/{eventId}',[SportbookController::class,'updateSportResult'])->name('updateSportResult');

Route::get('getEventDataAdmin', [SportbookController::class,'getEventDataAdmin'])->name('admin.getEventDataAdmin');
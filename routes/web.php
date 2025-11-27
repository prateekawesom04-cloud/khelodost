<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SportbookController;
use App\Http\Controllers\SportookBetController;


Route::middleware(['auth_middleware'])->group(function () {
    
    Route::get('/login', function () {
        return view('pages.login');
    })->name('login');

    Route::get('signin', function () {
        $referral_code = '';
        
        if(session()->has('referral_code')){
            
            $referral_code = session('referral_code');

        }

        // Session::flush();

        return view('pages.signin',compact('referral_code'));
        return view('pages.signin');
    })->name('signin');

    Route::post('signin', [AuthController::class,'signin'])->name('post.signin');
    Route::post('login', [AuthController::class,'login'])->name('post.login');

    Route::get('/forgot_password', function () {
        return view('pages.forgot_password');
    })->name('forgot_password');

    Route::get('social', [AuthController::class,'social'])->name('api.login.social');

    Route::get('callback/{redirect}', [AuthController::class,'callback'])->name('api.login.callback');
    
    Route::get('/refer/{referral_code}', [UserController::class,'referral_code'])->name('user.referral_code');

});

    // Route::middleware(['bonus_middleware'])->group(function () {
        
    // });

Route::middleware(['custom_session_middleware','bonus_middleware'])->group(function () {

    Route::middleware(['auth_check_middleware'])->group(function () {
        
        Route::post('paymentGatewayMethod', [TransactionController::class,'paymentGatewayMethod'])->name('paymentGatewayMethod')->withoutMiddleware([VerifyCsrfToken::class]);
 
        // Route::get('deposit', [UserController::class,'deposit'])->name('user.deposit');
        
        Route::post('addStake', [UserController::class,'addStake'])->name('user.post.addStake')->withoutMiddleware([VerifyCsrfToken::class]);
        
        Route::post('placebet', [SportookBetController::class,'placebet'])->name('user.placebet')->withoutMiddleware([VerifyCsrfToken::class]);
        
        Route::get('openbets', [UserController::class,'openbets'])->name('user.openbets')->withoutMiddleware([VerifyCsrfToken::class]);
        
        Route::get('eventBets', [UserController::class,'eventBets'])->name('user.eventBets')->withoutMiddleware([VerifyCsrfToken::class]);

        Route::get('bonus', [UserController::class,'bonus'])->name('user.bonus');
        
        Route::get('userBalance', [UserController::class,'userBalance'])->name('user.userBalance');

        Route::post('claimBonus', [UserController::class,'claimBonus'])->name('user.post.claimBonus')->withoutMiddleware([VerifyCsrfToken::class]);

        Route::get('betlist', [UserController::class,'betlist'])->name('user.betlist');
        
        Route::get('live_game_bet_history', [UserController::class,'live_game_bet_history'])->name('user.live_game_bet_history');
        Route::get('transaction_history', [UserController::class,'transaction_history'])->name('user.transaction_history');
        
        Route::get('/withdraw', function () {
            return view('accounts.withdraw');
        })->name('user.withdraw');
            // Route::get('withdraw', [UserController::class,'withdraw'])->name('user.withdraw'); 

        // Route::get('/account_statement', function () {
        //     return view('accounts.account_statement');
        // })->name('account_statement');
        Route::get('account_statement', [UserController::class,'account_statement'])->name('account_statement'); 

        // Route::get('/open_bets', function () {
        //     return view('accounts.open_bets');
        // })->name('open_bets');

        // Route::get('/profit_loss_event', function () {
        //     return view('accounts.profit_loss_event');
        // })->name('profit_loss_event');
        Route::get('profit_loss_event', [UserController::class,'profit_loss_event'])->name('profit_loss_event'); 
        
        Route::get('referred_users', [UserController::class,'referred_users'])->name('user.referred_users'); 

        Route::get('/change_password', function () {
            return view('accounts.change_password');
        })->name('change_password');

        Route::post('changePassword', [UserController::class,'changePassword'])->name('user.changePassword')->withoutMiddleware([VerifyCsrfToken::class]);

        Route::get('/account_setting', function () {
            return view('accounts.account_setting');
        })->name('account_setting');

        
        Route::get('logout', function () {
            session()->forget('username');
            // Session::flush('username');
            return redirect()->route('index');
        })->name('logout');
    });

    Route::get('eventPage/{eventId}', [SportbookController::class,'eventPage'])->name('user.eventPage');
    
    Route::get('soccerEvent/{eventId}', [SportbookController::class,'soccerEvent'])->name('user.soccerEvent');
    
    Route::get('eventDetail/{eventId}', [SportbookController::class,'soccerEvent'])->name('user.eventDetail');
    
    Route::get('sport/{sportname}', [SportbookController::class,'sport'])->name('user.sport');
    
    Route::get('getSportData/{sportname}', [SportbookController::class,'getSportData'])->name('user.getSportData');
    
    Route::get('eventData', [SportbookController::class,'eventData'])->name('user.eventData');
    
    Route::get('getEventData', [SportbookController::class,'getEventData'])->name('user.getEventData');
    
    Route::get('upcomingEventPage/{eventId}', [SportbookController::class,'upcomingEventPage'])->name('user.upcomingEventPage');
    
    Route::get('soccerUpcomingEvent/{eventId}', [SportbookController::class,'soccerUpcomingEvent'])->name('user.soccerUpcomingEvent');
    
    Route::get('upcomingEventData', [SportbookController::class,'upcomingEventData'])->name('user.upcomingEventData');

    Route::get('otherSportEventPage/{eventId}', [SportbookController::class,'otherSportEventPage'])->name('user.otherSportEventPage');
    
    Route::get('exposure', [UserController::class,'exposure'])->name('user.exposure');


    Route::get('/', function () {
        return view('pages.index');
    })->name('index');

    Route::get('design', function () {
        return view('design');
    })->name('design');

    Route::get('/cricket', function () {
        return view('pages.cricket');
    })->name('cricket');

    Route::get('/football', function () {
        return view('pages.football');
    })->name('football');

    Route::get('/tennis', function () {
        return view('pages.tennis');
    })->name('tennis');

    Route::get('/indian_card_games', function () {
        return view('pages.indian_card_games');
    })->name('indian_card_games');

    Route::get('/casino', function () {
        return view('pages.casino');
    })->name('casino');

    Route::get('/1X2_gaming', function () {
        return view('pages.1X2_gaming');
    })->name('1X2_gaming');

    Route::get('/ezugi', function () {
        return view('pages.ezugi');
    })->name('ezugi');

    Route::get('/supernova', function () {
        return view('pages.supernova');
    })->name('supernova');

    Route::get('/slot_casino', function () {
        return view('pages.slot_casino');
    })->name('slot_casino');

    // Account page 
    // Route::get('/deposit', function () {
    //     return view('accounts.deposit');
    // })->name('deposit');
        Route::get('deposit', [UserController::class,'deposit'])->name('user.deposit'); 

            
    Route::post('paymentCallback', [TransactionController::class,'paymentCallback'])->name('paymentCallback')->withoutMiddleware([VerifyCsrfToken::class]);
    Route::post('paymentCallbackInd', [TransactionController::class,'paymentCallbackInd'])->name('paymentCallbackInd')->withoutMiddleware([VerifyCsrfToken::class]);
    Route::post('paymentCallbackBan', [TransactionController::class,'paymentCallbackBan'])->name('paymentCallbackBan')->withoutMiddleware([VerifyCsrfToken::class]);
    Route::post('apiCall', [TransactionController::class,'apiCall'])->name('apiCall')->withoutMiddleware([VerifyCsrfToken::class]);
       
});
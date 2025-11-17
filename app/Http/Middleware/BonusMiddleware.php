<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Bonus;

class BonusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        $userData = User::where('username', Session::get('username'))->first();
        if(!$userData){
            View::share('claim_bonus',0);
            return $next($request);
        }

        $bonuses = json_decode($userData->bonus,true);
        // dd($bonuses);
        $shareBonus = [];
        $claim_bonus = 0;

        if($bonuses && count($bonuses) > 0){
            $claim_bonus = 1;

            foreach($bonuses as $bonus){
                // if($bonus['claim_status'] == 0 && $bonus['type'] == 0){
                    // $claim_bonus = 1;
                    $bonus['description'] = Bonus::where('bonus_uid',$bonus['bonus_uid'])->first()->description;
                    $shareBonus[] = $bonus;
                // }
            }
        }
        
        // $shareBonus = json_encode($shareBonus);

        if($claim_bonus){
            View::share('claim_bonus',1);
            View::share('shareBonus',$shareBonus);
        } else{
            View::share('claim_bonus',0);
        }

        return $next($request);
    }
}

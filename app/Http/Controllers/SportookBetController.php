<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SportookBet;

class SportookBetController extends Controller
{
    //
    public function placebet(Request $request){
        // dd('$request',$request->all());

        // foreach ($request->all() as $req) {
        //     i(!$req){

        //     }
        // }

        $user = User::getCurrentUser();

        $request->username = $user->username;

        $request->betId = substr($user->username,0,5).'_'.rand(1000,9999).'_'.substr(time(),6,strlen(time())-1);

        $bet = new SportookBet();
        $bet->username = $user->username;
        $bet->betId = $request->betId;
        $bet->mname = $request->mname;
        $bet->betOn = $request->betOn;
        $bet->eventId = $request->eventId;
        $bet->marketId = $request->marketId;
        $bet->wallet_before = $user->wallet_amount;
        $bet->oddVal = $request->oddVal;
        $bet->bet_amount = $request->bet_amount;
        $bet->profit = $request->profit;
        // $bet->loss = $request->loss;
        $bet->ip = $request->ip();
        $bet->status = 0;
        $bet->save();

        $user->wallet_amount -= $request->bet_amount;
        $user->unsattled_amount += $request->bet_amount;
        $user->save();

        return response()->json([
            'code'=>'200',
            'message'=> 'Bet Placed Successfully'
        ]);


    }

    // public function openBets(Request $request){
    //     $openBets = SportookBet::whereIn('status',[1])->orderBy('id','desc')->get();

    //     // dd($openBets);
    //     if(count($openBets)){
    //         return response()->json([
    //             'code'=>'200',
    //             'data'=> $openBets
    //         ]);
    //     } else{
    //         return response()->json([
    //             'code'=>'401',
    //             'data'=> 'No Openbets Available'
    //         ]);
    //     }
    // }
}

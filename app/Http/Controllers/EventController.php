<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Event;
use App\Models\SportookBet;

class EventController extends Controller
{
    //
    public function eventStatus(Request $request){
        $banner = Event::where('eventId',$request->eventId)->first();
        $banner->status = $banner->status?0:1;
        $banner->save();
        
        return response()->json([
            'message'=> 'Event Updated Successfully',
            'response_code'=> '200',
        ]);
    }

    public function eventDetail(Request $request){


        // $marketNatData = SportookBet::select('mname', 'nat', DB::raw('SUM(bet_amount) as exposure, COUNT(*) as totalBets'))
        // ->groupBy('mname','nat');

        $marketData = SportookBet::select('eventId','mname', 'nat', DB::raw('SUM(bet_amount) as exposure, COUNT(*) as totalBets'))
        ->groupBy('eventId','mname','nat')
        ->where('eventId',$request->eventId)->get();

        $MATCH_ODDS = SportookBet::select('eventId','mname', 'nat', DB::raw('SUM(bet_amount) as exposure, COUNT(*) as totalBets'))
        ->groupBy('eventId','mname','nat')
        ->where('mname','matchOdds')->get();

        $Bookmaker = SportookBet::select('eventId','mname', 'nat', DB::raw('SUM(bet_amount) as exposure, COUNT(*) as totalBets'))
        ->groupBy('eventId','mname','nat')
        ->where('mname','Bookmaker')->get();

        $TIED_MATCH = SportookBet::select('eventId','mname', 'nat', DB::raw('SUM(bet_amount) as exposure, COUNT(*) as totalBets'))
        ->groupBy('eventId','mname','nat')
        ->where('mname','TIED_MATCH')->get();

        $Normal = SportookBet::select('eventId','mname', 'nat', DB::raw('SUM(bet_amount) as exposure, COUNT(*) as totalBets'))
        ->groupBy('eventId','mname','nat')
        ->where('mname','Normal')->get();



        // dd($marketData,$Bookmaker);
        
        return view('admin.pages.eventDetail',compact('marketData','MATCH_ODDS','Bookmaker','TIED_MATCH','Normal'));
    }

}

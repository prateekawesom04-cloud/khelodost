<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use App\Events\EventNotification;
use App\Models\Event;
use App\Models\Market;

class SportbookController extends Controller
{
    //

    public function sport(Request $request){
        $sportname = $request->sportname;
        return view('pages.'.$sportname,compact('sportname'));
    }

    public function getSportFixture(Request $request){
        $sportname = $request->sportname;
        $sportData = Cache::remember($sportname, 60, function () use ($sportname) {
            $client = new Client(); 
            $response = $client->get("https://marketsarket.qnsports.live/get".$sportname."matches2"); 
            $body = $response->getBody(); 
            // $body = $response->getBody()->getContents(); 
            // event(new EventNotification($sportData));
            return json_decode($response->getBody(), true);
            
            // return User::where('active', 1)->get();
        });

        return $sportData;
    }

    public function getCricketEventData(Request $request){
        $sportname = $request->sportname;
        $sportData = Cache::remember($sportname, 60, function () use ($sportname) {
            $client = new Client(); 
            $response = $client->get("http://170.187.250.13/getbm?eventId=".$request->eventId); 
            $body = $response->getBody(); 
            // $body = $response->getBody()->getContents(); 
            // event(new EventNotification($sportData));
            return json_decode($response->getBody(), true);
            
            // return User::where('active', 1)->get();
        });

        return $sportData;
    }

    public function eventPage(Request $request){
        // $body = Storage::get('event/'.$request->eventId.'.json');
        // $body = json_decode($body);
        $eventId = $request->eventId;
        $eventData = Event::where('eventId',$request->eventId)->first();
        return view('pages.eventPage',compact('eventId','eventData'));
    }
    
    public function soccerEvent(Request $request){
        $eventId = $request->eventId;
        $eventData = Event::where('eventId',$request->eventId)->first();
        // $eventData = Event::where('eventId',$request->eventId);
        // $market = Market::joinSub($eventData,'eventData',function($join){
        //     $join->on('markets.name','=','eventData.sportname');
        // })->get();
        $market = Market::where('name',$eventData->sportname)->first();
        // dd($market);
        return view('pages.soccerEventPage',compact('eventId','eventData','market'));
    }

    public function soccerUpcomingEvent(Request $request){
        $eventId = $request->eventId;
        return view('pages.soccerUpcomingEventPage',compact('eventId'));
    }

    public function inplay(Request $request){
        $eventId = $request->eventId;
        return view('pages.inplay',compact('eventId'));
    }

    public function eventData(Request $request){
        $body = Storage::get('event/inplay/'.$request->eventId.'.json');

        // dd($body);
        return response()->json([
            'response'=>$body,
            'response_code'=>'200'
        ]);
    }

    public function upcomingEventPage(Request $request){
        // $body = Storage::get('event/'.$request->eventId.'.json');
        // $body = json_decode($body);
        $eventId = $request->eventId;
        return view('pages.upcomingEventPage',compact('eventId'));
    }

    public function upcomingEventData(Request $request){
        $body = Storage::get('event/upcoming/'.$request->eventId.'.json');

        // dd($body);
        return response()->json([
            'response'=>$body,
            'response_code'=>'200'
        ]);
    }

    
    public function getSportData(Request $request){
        $body = Storage::get('sports/'.$request->sportname.'.json');

        // dd($body);
        return response()->json([
            'data'=>$body,
            'sport'=>$request->sportname,
            'response_code'=>'200'
        ]);
    }
    
    public function getEventData(Request $request){
        $body = Storage::get('event/'.$request->eventId.'.json');

        // dd($body);
        return response()->json([
            'response'=>$body,
            'response_code'=>'200'
        ]);
    }

    public function getEventDataAdmin(Request $request){
        $body = Storage::get('sattleEvent/'.$request->eventId.'.json');

        // dd($body);
        return response()->json([
            'response'=>$body,
            'response_code'=>'200'
        ]);
    }
}

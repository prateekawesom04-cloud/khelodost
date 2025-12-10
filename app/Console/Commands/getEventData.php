<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Pusher\Pusher;
use GuzzleHttp\Client;
use App\Events\EventNotification;

class getEventData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-event-data {sportname}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //

        $sportname = $this->argument('sportname');
        $eventData = Storage::get('sports/'.$sportname.'.json');

        $eventData = json_decode($eventData,true);
        
        $eventData = array_chunk($eventData,15);

        $inplaySports = [];

        foreach ($eventData as $chunk) {
            foreach ($chunk as $item) {
                // if($item['inPlay']){
                    if($sportname=='cricket'){
                        $inplaySports[] = $item['gameId'];
                    } else{
                        $inplaySports[] = $item['gmid'];
                    }
                // }
            }
        }
        
        // $body = array_slice($sportdataArray, 0, 15);

        $eventData = array_slice($eventData, 0, 10);

        $client = new Client(); 
        foreach ($inplaySports as $eventId) {
            
            if($sportname=='cricket'){
                $response = $client->get("http://170.187.250.13/getbm?eventId=".$eventId); 
            } else{
                $response = $client->get("http://172.232.74.157/getdata?eventId=".$eventId); 
            }
            $body = $response->getBody(); 
            $body = $response->getBody()->getContents(); 
            
            Storage::put('event/'.$eventId.'.json', $body);

            event(new EventNotification($body));

            if(!file_exists(storage_path('app/private/sattleEvent/'.$eventId.'.json'))){
                Storage::put('sattleEvent/'.$eventId.'.json', $body);
            } else{
                $sattleEventData = Storage::get('sattleEvent/'.$eventId.'.json');
                $sattleEventData = json_decode($sattleEventData,true);
                $newEventData = json_decode($body,true);
                // dump(json_encode($sattleEventData));
                $sattleEventData = $this->my_merge($sattleEventData,$newEventData);
                // dd('json_encode($sattleEventData)',json_encode($sattleEventData));
                
                Storage::put('sattleEvent/'.$eventId.'.json', json_encode($sattleEventData));
            }
            
            usleep(500000);
        }

        // $options = [
        //     'cluster' => env('PUSHER_APP_CLUSTER'),
        //     'useTLS' => true
        // ];

        // $pusher = new Pusher(
        //     env('PUSHER_APP_KEY'),
        //     env('PUSHER_APP_SECRET'),
        //     env('PUSHER_APP_ID'),
        //     $options
        // );

        
        // $body = json_encode($body);

        // $response = $pusher->trigger('inplayUpdate', 'inplayUpdate-event', ['data' => $body,'sport'=>$sportname]);
          
    }
        
    public function my_merge( $arr1, $arr2 )
    {
        $keys = array_keys( $arr2 );
        $arr2Normal = array_filter($arr2['data'], function($item){
            return $item['mname'] == 'Normal';
        });
        foreach($arr2Normal as $key=>$val ) { 
            $arr2Normal = $val; 
        }
        // dd($arr2Normal);
        $arr1Normal = array_filter($arr1['data'], function($item){
            return $item['mname'] == 'Normal';
        });
        foreach($arr1Normal as $key=>$val ) { 
            $arr1Normal = $val; 
        }

        // dd($arr1Normal);
        if(!count($arr1Normal)){
            $arr1['data'][] = $arr2Normal;
        } else{
            foreach( $arr2Normal['section'] as $key=>$val ) { 
        // dd('$arr2Normal',$arr2Normal,'$val',$val,'$arr1Normal',$arr1Normal);
                $arr1Sid = array_filter($arr1Normal['section'], function($item) use($val){
                    return $item['sid'] == $val['sid'];
                });
                // dd( $arr1Sid);
                if(!count($arr1Sid)){
                    $arr1Normal['section'][] = $val;
                }
        }

        }
        return $arr1;
    }
}

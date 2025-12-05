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

            if(!file_exists(storage_path('app/private/sattleEvent/'.$eventId.'.json'))){
                Storage::put('sattleEvent/'.$eventId.'.json', $body);
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
}

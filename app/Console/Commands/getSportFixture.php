<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Pusher\Pusher;
use GuzzleHttp\Client;
use App\Events\EventNotification;

class getSportFixture extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-sport-fixture {sportname}';

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
        // $sportData = Cache::remember($sportname, 1, function () use($sportname) {
            // $sportname = $this->argument('sportname');
            $client = new Client(); 
            $response = $client->get("https://marketsarket.qnsports.live/get".$sportname."matches2"); 
            $body = $response->getBody(); 
            $body = $response->getBody()->getContents(); 
            // event(new EventNotification($body));
            // return $body;
        // });

        $options = [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true
        ];

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        // $body = Storage::get('sports/'.$sportname.'.json');
        
        $body = json_decode($body,true);
        $body = array_chunk($body,15);
        $sportDataArray = [];
        $sportInplayDataArray = [];
        $sportUpcomingDataArray = [];
        
        foreach ($body as $chunk) {
            foreach ($chunk as $item) {
                if($sportname=='cricket'){

                    if($item['marketId']){
                        $data = [];
                        $data['eventName'] = $item['eventName'] ?? '';
                        $data['gameId'] = $item['gameId'] ?? '';
                        $data['marketId'] = $item['marketId'] ?? '';
                        $data['back11'] = $item['back11'] ?? '';
                        $data['back1'] = $item['back1'] ?? '';
                        $data['back12'] = $item['back12'] ?? '';
                        $data['lay11'] = $item['lay11'] ?? '';
                        $data['lay1'] = $item['lay1'] ?? '';
                        $data['lay12'] = $item['lay12'] ?? '';
                        $data['section'] = $item['section'] ?? '';
                        $data['beventId'] = $item['beventId'] ?? '';
                        $data['inPlay'] = $item['inPlay'] ?? '';
                        
                        $sportDataArray[] = $data;

                        $date = explode(' / ',$item['eventName'])[1];
                        $date = explode(' (IST)',$date)[0];
                        
                        // if(strtotime(now()) > strtotime($date) && $item['inPlay']=="True"){
                        if($item['inPlay']=="True"){
                            $sportInplayDataArray[] = $data;
                        } else if(strtotime(now()) < strtotime($date)){
                            $sportUpcomingDataArray[] = $data;
                        }
                    }

                } else{
                    
                    if($item['mid']){
                        $data = [];
                        $data['gmid'] = $item['gmid'] ?? '';
                        $data['ename'] = $item['ename'] ?? '';
                        $data['mid'] = $item['mid'] ?? '';
                        $data['mname'] = $item['mname'] ?? '';
                        $data['stime'] = $item['stime'] ?? '';
                        $data['section'] = $item['section'] ?? '';
                        $data['beventId'] = $item['beventId'] ?? '';
                        $data['iplay'] = $item['iplay'] ?? '';
                        
                        $sportDataArray[] = $data;
                        $date = $item['stime'];
                        
                        // if(strtotime(now()) > strtotime($date) && $item['iplay']=="true"){
                        if($item['iplay']=="true"){
                            $sportInplayDataArray[] = $data;
                        } else if(strtotime(now()) < strtotime($date)){
                            $sportUpcomingDataArray[] = $data;
                        }
                    }

                }
            }
        }

        // $sportInplayDataArray = array_slice($sportInplayDataArray, 0, 2);
        

        $body = $sportDataArray;
        // $body = array_merge($sportInplayDataArray,$sportUpcomingDataArray);
        // $body = array_slice($body, 0, 10);
        if($sportname!='cricket'){
            $body = array_slice($body, 0, 9);
        }
        $body = json_encode($body);

        $sportInplayDataArray = json_encode($sportInplayDataArray);
        $sportUpcomingDataArray = json_encode($sportUpcomingDataArray);
        
        Storage::put('sports/'.$sportname.'.json', $body);
        Storage::put('sports/inplay/'.$sportname.'.json', $sportInplayDataArray);
        Storage::put('sports/upcoming/'.$sportname.'.json', $sportUpcomingDataArray);
        Log::info('----'.$sportname);
        // $response = $pusher->trigger($sportname.'-sportsupdate', $sportname.'-sportsupdate-event', ['data' => $body,'sport'=>$sportname]);
            

            // return json_decode($response->getBody(), true);
            
            // return User::where('active', 1)->get();
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Http\Controllers\Admin\AdminDataController;

class sattleBets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sattle-bets';

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
        $events = Event::where('status',1)->get();
        $adminDataController = new AdminDataController();

        $request = new Request();
        foreach($events as $event){
            $request->eventId = $event->eventId;
            $eventResults = json_decode($event->additional_data,true);
            // dump($eventResults);
            if(!$eventResults){
                continue;
            }
            foreach($eventResults as $k=>$market){
                // dd($market['mname']);
                // if($market['mname']=='Match Odds'){
                $request->marketId = $k;
                $request->mname = $market['mname'];
                $request->marketResults = $market;
                // dd($request);
                $adminDataController->sattleBets($request);
                    
                // }
            }

        }
    }
}

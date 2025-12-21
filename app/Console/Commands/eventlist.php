<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;


class eventlist extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:eventlist {sportname}';

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
        $sportData = Storage::get('sports/'.$sportname.'.json');

        $sportData = json_decode($sportData,true);

        // event status
        // 0 - inactive
        // 1 - inplay
        // 2 - upcoming
        // 3 - under settlement
        foreach($sportData as $event){
            
            if($sportname != 'cricket'){
                $eventId = $event['gmid'];
                $eventName = $event['ename'];
                $date = $event['stime'];
                $beventId = $event['beventId'];

                if($event['iplay']=="True") {
                    $status = (strtotime(now()) > strtotime($date)) ? 1 : 2;
                } else {
                    $status = 2;
                }

            } else {
                $eventId = $event['gameId'];
                $eventName = explode(' / ',$event['eventName'])[0];
                $date = explode(' / ',$event['eventName'])[1];
                $date = explode(' (IST)',$date)[0];
                $beventId = $event['beventId'];

                if($event['inPlay']=="True") {
                    $status = (strtotime(now()) > strtotime($date)) ? 1 : 2;
                } else {
                    $status = 2;
                }
            }

            $event = Event::where('eventId',$eventId)->first();
            if(!$event){
                $event = new Event();
            }
            $event->eventId = $eventId;
            $event->eventName = $eventName;
            $event->eventDate = $date;
            $event->sportname = $sportname;
            $event->beventId = $beventId;
            $event->status = $status;
            $event->save();
            // Event::updateOrCreate(
            //     ['eventId' => $eventId],
            //     [
            //         'eventName' => $eventName,
            //         'eventDate' => $date,
            //         'sportname' => $sportname,
            //         'beventId' => $beventId,
            //         'status' => $status
            //     ]
            // );
        }

    }
}

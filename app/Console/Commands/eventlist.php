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

        foreach($sportData as $event){
            
            if($sportname != 'cricket'){
                $eventName = $event['ename'];
                $date = $event['stime'];
                $status = (strtotime(now()) > strtotime($date)) ? 1 : 0;
            } else {
                $eventName = $event['eventName'];
                $date = $event['startDate'];
                $status = (strtotime(now()) > strtotime($date)) ? 1 : 0;
            }
            Event::updateOrCreate(
                ['eventId' => $event['gameId']],
                [
                    'eventName' => $eventName,
                    'eventDate' => $date,
                    'sportname' => $sportname,
                    'status' => $status
                ]
            );
        }

    }
}

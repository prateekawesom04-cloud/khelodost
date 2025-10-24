<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


// sport crons
Schedule::command('app:get-sport-fixture cricket')->everySecond();
Schedule::command('app:get-sport-fixture soccer')->everySecond();
Schedule::command('app:get-sport-fixture tennis')->everySecond();

// inplay event crons
Schedule::command('app:get-event-data cricket')->everySecond();
Schedule::command('app:get-event-data soccer')->everySecond();
Schedule::command('app:get-event-data tennis')->everySecond();

Schedule::command('app:eventlist cricket')->daily();
Schedule::command('app:eventlist soccer')->daily();
Schedule::command('app:eventlist tennis')->daily();

// upcoming event crons
// Schedule::command('app:get-upcoming-event-data cricket')->everySecond();
// Schedule::command('app:get-upcoming-event-data soccer')->everySecond();
// Schedule::command('app:get-upcoming-event-data tennis')->everySecond();
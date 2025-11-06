<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Schema;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Bonus;
use App\Models\Transaction;
use App\Models\Activity;
use App\Models\Payment;
use App\Models\Appdata;
use App\Models\GameHistory;
use App\Models\Event;
use App\Models\SportookBet;

class AdminDataController extends Controller
{
    //

    protected $model_map = [
            'users'=>'App\Models\User',
            'transactions'=>'App\Models\Transaction',
            'payments'=>'App\Models\Payment',
        ];

    public function checkMasterPassword($masterPassword){
            
        $user = User::getCurrentUser();
        if(!Hash::check($masterPassword,$user->password)){
            return false;
        }
        return true;
    }
    
    public function index(){
        $user = User::getCurrentUser();
        // $gameData = GameHistory::join('users','users.username','=','game_histories.username')->where('admin_username',$user->username)->get();
        $p_l = 0;
        // foreach($gameData as $g_user){
        //     $p_l+=$g_user->bet_amount;
        // }
        
        //total event exposure
        $allEvents = Event::where('status',1)->limit(20)->get();

        // $events = DB::table('sportook_bets')
        $eventsExposure = SportookBet::select('eventId', DB::raw('SUM(bet_amount) as exposure'))
        // ->join('sportook_bets', 'events.eventId', '=', 'sportook_bets.eventId')
        ->groupBy('eventId');
        // ->select('events.eventId', DB::raw('SUM(sportook_bets.bet_amount) as total_bet_amount'))
        // ->where('events.status', 1)
        // ->get();
        // $events = Event::where('events.status',1)->join('sportook_bets','sportook_bets.eventId','=','events.eventId')->select('events.*','sportook_bets.*',"SUM('sportook_bets.bet_amount')")->get();

        $events = Event::joinSub($eventsExposure,'eventsExposure',function($join){
            $join->on('events.eventId','=','eventsExposure.eventId');
        })
        ->where('status',1);
        
        $cricketEvents = $events->where('sportname','cricket')->get();
        $footballEvents = $events->where('sportname','football')->get();
        $tennisEvents = $events->where('sportname','tennis')->get();
        

        // dd($events);
        $user = User::whereIn('status', [2])->count();
        $userTotal = User::all()->count();
        // $totalBets = count($gameData);
        return view('admin.pages.index',compact('user','userTotal','p_l','allEvents','cricketEvents','footballEvents','tennisEvents'));
    }
    
    
    public function inactive_user_downline_list(Request $request){
        $users = User::where('status', 6)->get();
        return view('admin.pages.user_downline_list',compact('users'));
    }

    public function userStatments(Request $request){
        $table = Transaction::where([
            'username'=>$request->username,
            'payment_type'=>$request->filter_type
        ])->get();

        return response()->json([
            'data'=> $table,
            'redirect'=> url()->previous(),
            'response_code'=>'200'
        ]);
    }

    public function userGameHistory(Request $request){
        $table = GameHistory::where([
            'username'=>$request->username,
            'provider'=>$request->filter_type
        ])->get();
           
        return response()->json([
            'data'=> $table,
            'redirect'=> url()->previous(),
            'response_code'=>'200'
        ]);
    }

    public function bonusData(){
        $bonus = Bonus::all();
        $assignBonus = Bonus::where(['type'=>1,'status'=>1])->get();
        return view('admin.pages.bonus',compact('bonus','assignBonus'));
    }

    public function changeBonusStatus(Request $request){
        $bonus = Bonus::where('bonus_uid',$request->bonus_uid)->first();
        $bonus->status = $request->status;
        $bonus->save();

        return response()->json([
            'message'=> 'Bonus Updated Successfully',
            'response_code'=> '200'
        ]);
    }

    public function updateBonus(Request $request){
        $bonus = Bonus::where('bonus_uid',$request->bonus_uid)->first();
        $bonus->amount = $request->amount;
        $bonus->wager_amount = $request->wager_amount;
        $bonus->description = $request->description;
        $bonus->save();

        return response()->json([
            'message'=> 'Bonus Updated Successfully',
            'response_code'=> '200'
        ]);
    }

    public function createBonus(Request $request){
        $bonus = new Bonus();
        $bonus->bonus_uid = time().rand(111,999);
        $bonus->type = $request->type;
        $bonus->amount = $request->amount;
        $bonus->wager_amount = $request->wager_amount;
        $bonus->description = $request->description;
        $bonus->status = 1;
        $bonus->save();

        return response()->json([
            'message'=> 'Bonus created',
            'response_code'=> '200'
        ]);

    }

    public function add_bonus(){
        $bonus = Bonus::all();
        return view('admin.pages.add_bonus',compact('bonus'));
    }

    public function assignBonus(Request $request){
        

        $userData =  User::where('username',$request->username)->first();

        $bonus = json_decode($userData->bonus,true);

        $bonus[$request->bonus_uid]['bonus_uid'] = $request->bonus_uid;
        $bonus[$request->bonus_uid]['amount'] = $request->amount;
        $userData->bonus = json_encode( $bonus);
        $userData->save();

        return response()->json([
            'message'=> 'Bonus added',
            'response_code'=> '200'
        ]);
    }


    // admin pages

    public function submitForm(Request $request){   
        $user = User::getCurrentUser();
        if(!Hash::check($request->masterPassword,$user->password)){
            return response()->json([
                'error'=> 'wrong master password',
                'response_code'=>'400'
            ]);
        }
        $user = new User();

        // $user = User::whereIn('status', [1,2])->first();
        $tableName = (new User())->getTable();
        $columns = Schema::getColumnListing($tableName);
        array_splice($columns, 0, 1);
        array_splice($columns, count($columns)-2, 2);

        $request->phone = rand(0000000000,1111111111);
        foreach ($columns as $key => $value) {
            $user->{$value} = $request->{$value};
        }
        
        foreach ($columns as $key => $value) {
            $user->{$value} = $request->{$value};
        }
        $user->user_setting = json_encode($request->all());
        $user->save();

        return response()->json([
            'redirect'=> $request->previous_url,
            'response_code'=>'200'
        ]);
    }

    
    public function getDateRangeData(Request $request){

        dd($request->all());

        return response()->json([
            'redirect'=> $request->previous_url,
            'response_code'=>'200'
        ]);
    }

    public function createModelData(Request $request){

        // if ($request->hasFile('payment_method_uid')) {
        if (!empty($request->allFiles())) {
            $file = $request->file('payment_method_uid');
            $request->payment_method_uid = '/img/'.time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('', $request->payment_method_uid, 'public'); // Store in 'public/uploads'

        }
        
        $table = $this->model_map[$request->m_key];
        
        $table = new $table();
        
        $tableName = $table->getTable();
        $columns = Schema::getColumnListing($tableName);
        array_splice($columns, 0, 1);
        array_splice($columns, count($columns)-2, 2);
        
        foreach ($columns as $key => $value) {
            $table->{$value} = $request->{$value};
        }
        if(property_exists($table,'additional_data')){
            $table->additional_data = json_encode($request->all());
        }

        $table->save();

        return response()->json([
            'redirect'=> $request->previous_url,
            'response_code'=>'200'
        ]);
    }

    public function getModelData(Request $request){
        
        $table = $this->model_map[$request->m_key];
        $table = new $table();
        $table = $table->where([
            $request->search_data_key=>$request->search_data_value,
            'username'=>$request->username
            ])->get();
        // dd($table);
        
        return response()->json([
            'data'=> $table,
            'redirect'=> $request->previous_url,
            'response_code'=>'200'
        ]);
    }
    
    public function updateModelData(Request $request){
        
        $table = $this->model_map[$request->m_key];
        
        $table = new $table();
        $table = $table->where($request->search_data_key,$request->search_data_value)->first();
        $table->{$request->update_data_key} = $request->update_data_value;
        $table->save();
        
        return response()->json([
            'redirect'=> $request->previous_url,
            'response_code'=>'200'
        ]);
    }
     
    public function submitUserUpdates(Request $request){
        
        $table = $this->model_map[$request->m_key];
        $table = new $table();
        $tableName = $table->getTable();
        
        $table = $table->where($request->search_data_key,$request->search_data_value)->first();
        dd($table);
        $columns = Schema::getColumnListing($tableName);
        array_splice($columns, 0, 1);
        array_splice($columns, count($columns)-2, 2);
        
        foreach ($columns as $key => $value) {
            if(isset($request->{$value})){
                $table->{$value} = $request->{$value};
            }
        }

        $table->save();
        
        return response()->json([
            'redirect'=> $request->previous_url,
            'response_code'=>'200'
        ]);
    }

   
    
    public function deposit(){
        $user = User::getCurrentUser();
        $transactions = User::join('transactions','transactions.username','=','users.username')
        ->select('transactions.*','users.admin_username')
        ->where([
            'admin_username'=>$user->username,
            'payment_type'=>0,
            'manual'=>1
        ])
        ->get();
        return view('admin.pages.deposit',compact('transactions'));
    }
    
    public function withdraw(){
        $user = User::getCurrentUser();
        $transactions = User::join('transactions','transactions.username','=','users.username')
        ->select('transactions.*','users.admin_username')
        ->where([
            'admin_username'=>$user->username,
            'payment_type'=>1,
            'manual'=>1
        ])->get();
        // dd($transactions);
        return view('admin.pages.withdraw',compact('transactions'));
    }
    
    public function payments(){
        $user = User::getCurrentUser();
        $payments = Payment::where('admin_username',$user->username)->get();
        return view('admin.pages.payments',compact('payments'));
    }

    public function commission(){
        
        return view('admin.pages.commission');
    }
    
    public function addFund(Request $request){
        if(!$this->checkMasterPassword($request->masterPassword)){
            return response()->json([
                'error'=> 'wrong master password',
                'response_code'=>'400'
            ]);
        }
        $user = User::where('username',$request->username)->first();
        $user->wallet_amount += $request->depositFund;
        $user->save();
        return response()->json([
            'error'=> 'Fund Added Successfully',
            'response_code'=>'200'
        ]);
    }
    

    public function news_view(Request $request){
        $domain = $request->host();
        $news  = [];
        // $appData = Appdata::where('app_domain',$domain)->first();
        $appData = User::getCurrentUser();
        $additional_data = json_decode($appData->additional_data);
        // dd($additional_data);
        if($additional_data){
            if(property_exists($additional_data,'marquee')){
                $news = $additional_data->marquee;
            }
        }
        // dd($news);
        return view('admin.pages.news_view',compact('news'));
    }
      
    public function update_news(Request $request){
        $newsData = [];
        $domain = $request->host();
        // $appData = Appdata::where('app_domain',$domain)->first();
        $appData = User::getCurrentUser();
        $additional_data = json_decode($appData->additional_data,true);
        $newsData['news_id'] = isset($additional_data['marquee'])?count($additional_data['marquee']):0;
        $newsData['news'] = $request->news;
        // dd($newsData);
        if(isset($request->news_id)){
            $additional_data['marquee'][$request->news_id]['news'] = $request->news;
        } else{
            $additional_data['marquee'][] = $newsData;
        }
        $appData->additional_data = json_encode($additional_data);
        $appData->save();

        return response()->json([
            'redirect'=> url()->previous(),
            'response_code'=>'200'
        ]);
    }

    public function delete_news(Request $request){
        $newsData = [];
        $domain = $request->host();
        // $appData = Appdata::where('app_domain',$domain)->first();
        $appData = User::getCurrentUser();
        $additional_data = json_decode($appData->additional_data,true);
        unset($additional_data['marquee'][$request->news_id]);
        $appData->additional_data = json_encode($additional_data);
        $appData->save();

        return response()->json([
            'redirect'=> url()->previous(),
            'response_code'=>'200'
        ]);
    }

    public function updatePhone(Request $request){
        if(!$this->checkMasterPassword($request->masterPassword)){
            return response()->json([
                'error'=> 'wrong master password',
                'response_code'=>'400'
            ]);
        }
        $user = User::where('username',$request->username)->first();
        $user->phone = $request->phone;
        $user->save();
        return response()->json([
            'error'=> 'Phone Updated Successfully',
            'response_code'=>'200'
        ]);
    }

    public function deleteUser(Request $request){
        if(!$this->checkMasterPassword($request->masterPassword)){
            return response()->json([
                'error'=> 'wrong master password',
                'response_code'=>'400'
            ]);
        }
        $user = User::where('username',$request->username)->delete();
        return response()->json([
            'redirect'=> url()->previous(),
            'response_code'=>'200'
        ]);
    }

    public function betlist(Request $request){
        $bets = SportookBet::all();
        // $bets = SportookBet::where('status',0)->get();
        return view('admin.pages.betlist',compact('bets'));
    }

    public function sattlement(Request $request){
        // $eventId = $request->eventId;
        $events = Event::where('status',1)->get();
        return view('pages.sattlement',compact('events'));
    }

    public function sattleEvent(Request $request){
        // dd($request->all());
        $eventId = $request->eventId;
        $marketId = $request->marketId;
        $result = $request->result;
        
        $event = Event::where('eventId',$eventId)->first();
        // $event = Event::where('eventId',$eventId)->where('marketId',$eventId)->first();
        // dd($event);
        // $event->status = $result;
        // $event->status = 2; // settled
        // $event->save();

        $sattledBets = SportookBet::where(
            [
            'status'=>1,
            'eventId'=>$eventId,
            'marketid'=>$request->marketId
            ])
            ->select('username','bet_amount','oddVal','profit')->get();

        if($sattledBets->count()){
            return $this->editSattleEvent($request);
        }

        $wonUsers = SportookBet::where(
            [
            'status'=>0,
            'eventId'=>$eventId,
            'betOn'=>$result,
            'marketid'=>$request->marketId
            ])
            ->select('username','bet_amount','oddVal','profit')->get();

        $lossUsers = SportookBet::where(
            [
            'status'=>0,
            'eventId'=>$eventId,
            'marketid'=>$request->marketId
            ])
            ->where('betOn','!=',$result)->select('username','bet_amount','oddVal','profit')->get();

        // dump('wonusers---',$wonUsers);
        // dd('lossUsers-----',$lossUsers);
        if($wonUsers->count()){
            
            // $wonUsers = SportookBet::where('status',0)->where('eventId',$eventId)->select('username','bet_amount','oddVal','profit')->get();

            // dd($wonUsers);

            foreach ($wonUsers as $user) {
                $userData = User::where('username',$user->username)->first();
                $userData->wallet_amount += $user->profit;
                // $userData->wallet_amount += ($user->bet_amount * $user->oddVal);
                $userData->unsattled_amount -= $user->bet_amount;
                $userData->save();
            }

        }

            // dd($wonUsers);
        // } else if($result == 2){
        //     $bets = SportookBet::where('eventId',$eventId)->where('betOn',2)->get();
        // } else{
        //     $bets = SportookBet::where('eventId',$eventId)->where('betOn',3)->get();
        
        if($lossUsers->count()){
            foreach ($lossUsers as $user) {
                $userData = User::where('username',$user->username)->first();
                $userData->wallet_amount -= $user->bet_amount;
                // $userData->wallet_amount += ($user->bet_amount * $user->oddVal);
                $userData->unsattled_amount -= $user->bet_amount;
                $userData->save();
            }
        }

        // dd($lossUsers);

        $bets = SportookBet::where('eventId',$eventId)->where('status',0)->where('betOn',$result)->update(['status'=>1]);
        // $bets = SportookBet::where('eventId',$eventId)->get();
        // $bets = SportookBet::where('eventId',$eventId)->update(['betOn'=>$result]);

        return response()->json([
            'message'=> 'Event Sattled Successfully',
            'response_code'=> '200'
        ]);
    }
    
    public function editSattleEvent(Request $request){
        // dd($request->all());
        $eventId = $request->eventId;
        $marketId = $request->marketId;
        $result = $request->result;
        
        $event = Event::where('eventId',$eventId)->first();
        // $event = Event::where('eventId',$eventId)->where('marketId',$eventId)->first();
        // dd($event);
        // $event->status = $result;
        // $event->status = 2; // settled
        // $event->save();

        $wonUsers = SportookBet::where(
            [
            'status'=>0,
            'eventId'=>$eventId,
            'betOn'=>$result,
            'marketid'=>$request->marketId
            ])
            ->select('username','bet_amount','oddVal','profit')->get();

        $lossUsers = SportookBet::where(
            [
            'status'=>0,
            'eventId'=>$eventId,
            'marketid'=>$request->marketId
            ])
            ->where('betOn','!=',$result)->select('username','bet_amount','oddVal','profit')->get();

        // dump('wonusers---',$wonUsers);
        // dd('lossUsers-----',$lossUsers);
        if($wonUsers->count()){
            
            // $wonUsers = SportookBet::where('status',0)->where('eventId',$eventId)->select('username','bet_amount','oddVal','profit')->get();

            // dd($wonUsers);

            foreach ($wonUsers as $user) {
                $userData = User::where('username',$user->username)->first();
                $userData->wallet_amount += $user->profit;
                // $userData->wallet_amount += ($user->bet_amount * $user->oddVal);
                $userData->unsattled_amount -= $user->bet_amount;
                $userData->save();
            }

        }

            // dd($wonUsers);
        // } else if($result == 2){
        //     $bets = SportookBet::where('eventId',$eventId)->where('betOn',2)->get();
        // } else{
        //     $bets = SportookBet::where('eventId',$eventId)->where('betOn',3)->get();
        
        if($lossUsers->count()){
            foreach ($lossUsers as $user) {
                $userData = User::where('username',$user->username)->first();
                $userData->wallet_amount -= $user->bet_amount;
                // $userData->wallet_amount += ($user->bet_amount * $user->oddVal);
                $userData->unsattled_amount -= $user->bet_amount;
                $userData->save();
            }
        }

        dd($lossUsers);

        $bets = SportookBet::where('eventId',$eventId)->where('status',0)->where('betOn',$result)->update(['status'=>1]);
        // $bets = SportookBet::where('eventId',$eventId)->get();
        // $bets = SportookBet::where('eventId',$eventId)->update(['betOn'=>$result]);

        return response()->json([
            'message'=> 'Event Sattled Successfully',
            'response_code'=> '200'
        ]);
    }

    public function sattleBets(Request $request){
        $eventId = $request->eventId;
           
    }
    
    public function updateSportResult(Request $request){
        $eventId = $request->eventId;
        
    }
    

}

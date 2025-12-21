<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Bonus;
use App\Models\Payment;
use App\Models\UserBank;
use App\Models\SportookBet;
use App\Models\Event;
use App\Models\Activity;

class UserController extends Controller
{
    protected $currentUser;
    protected $user_additional_data;

    public function __construct(){
        $this->currentUser = User::getCurrentUser();
        if($this->currentUser){
            $this->user_additional_data = json_decode($this->currentUser->additional_data);
        }
    }

    public function changePassword(Request $request){
        // dd($request->all());
        $rules = [
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6',
            'confirm_password' => 'required|same:newPassword',
        ];
        
        $validator = Validator::make($request->all(), $rules);
        $errors = [];
        if($validator->fails()){
            foreach ($validator->errors()->messages() as $key => $value) {
                $errors[] = $value[0];
            }
            return response()->json([
                'message'=>$errors[0]
            ]);
        } else{
            if($request->phone){
                $user = User::where([
                    'phone'=>$request->phone
                ])->first();
            } else if($request->username){
                $user = User::where([
                'username'=>$request->username
                ])->first();
            } else{
                return response()->json([
                    'message'=> 'Provide Some Id',
                    'response_code'=> '402'
                ]);
            }
            // $user = User::getCurrentUser();
            // dd($user);
            if(!Hash::check($request->oldPassword,$user->password)){
                return response()->json([
                    'message'=> 'Old Password Mismatched',
                    'response_code'=> '401'
                ]);
            }
            $user->password = Hash::make($request->newPassword);
            $user->save();
            
            return response()->json([
                'message'=> 'success',
                'response_code'=> '200'
            ]);
            
        }

    }
    
    public function profile(Request $request){
        if(Session::get('user_session')=='demo_user_demo'){
            $data = [
                'user_id'=>'demo data',
                'available_chips'=>'demo data',
                'exposure'=>'demo data'
            ];
        } else{

            $user = $this->currentUser;
            
            $data = [
                'user_id'=>$user->phone,
                'available_chips'=>$user->wallet_amount,
                'exposure'=>$user->unsattled_amount
            ];

        }
        $data = (object)$data;

        return view('accounts.profile',compact('data'));
        
    }

    public function deposit(Request $request){
        
        $user = $this->currentUser;
        if($user){
            $agent = User::where('username',$user->username)->where('status','>',0)->first();
            $data = Transaction::where([
                'username'=>$user->username,
                'payment_type'=>'0'
            ])->orderBy('id','desc')->get();
            return view('accounts.deposit',compact('data','agent'));
        }
        return view('accounts.deposit');
        // $payments = Payment::where('admin_username',$user->admin_username)->get();

    }
    
    public function withdraw(Request $request){
        
        $user = $this->currentUser;

        $userBank = UserBank::where('username',$user->username)->first();
        // dd($userBank);
        if(!$userBank){
            return view('accounts.account_setting');
        }
        if($user){
            $agent = User::where('username',$user->username)->where('status','>',0)->first();
            $data = Transaction::where([
                'username'=>$user->username,
                'payment_type'=>'1'
            ])->orderBy('id','desc')->get();
            return view('accounts.withdraw',compact('data','agent'));
        }
        return view('accounts.withdraw');
        // $payments = Payment::where('admin_username',$user->admin_username)->get();

    }
    
    public function withdrawal(Request $request){
        
        $user = $this->currentUser;
        $data = Transaction::where([
            'username'=>$user->username,
            'payment_type'=>'1'
        ])->get();
        return view('accounts.withdraw',compact('data'));

    }

    public function enterStakes(Request $request){
        return view('accounts.enterStakes');
    }
    
    public function addStake(Request $request){
        $user = $this->currentUser;
        $oldStakes = json_decode($user->additional_data,true);
        $oldStakes['stakes'][] = $request->stake;
        
        $user->additional_data = json_encode($oldStakes);
        $user->save();
        
        return response()->json([
            'message'=> 'Stake added',
            'response_code'=> '200'
        ]);
    }

    public function transaction(Request $request){
        
        $user = $this->currentUser;
        $data = Transaction::where('username',$user->username)->get();
        return view('accounts.transaction',compact('data'));

    }

    public function refer_rewards(){

        $data = $this->currentUser;
        return view('accounts.refer_rewards',compact('data'));
    }

    public function referral_code(Request $request,$referral_code){
        Session::put(['referral_code'=>$referral_code]);
        // dd(Session::get('referral_code'));
        return redirect('signin');
    }

    public function notification(Request $request){
        $bonusData = $this->user_additional_data->bonusData;
        $notifications = '';
        if(property_exists($this->user_additional_data, 'notification')){
            $notifications = $this->user_additional_data->notification;
        }
        return view('accounts.notification',compact('bonusData','notifications'));
    }

    public function bonus(Request $request){
        
        $userData = $this->currentUser;
        // $bonusData = [];
        $bonus = json_decode($userData->bonus,true);
        // $bonus = json_decode($userData->bonus);
        foreach($bonus as $key => $value){
            // dd($value->bonus_uid);
        //     // if(!$bonusData['claim_status']){
                $value['description'] = Bonus::where('bonus_uid',$key)->first()->description;
                $bonus[$key] = $value;
        //     // }
        }
        // $bonus = json_decode($bonus);
        // dd($bonus);

        return view('accounts.bonus',compact('bonus'));
    }

    public function claimBonus(Request $request){

        $userData = $this->currentUser;
        $admin = User::where('username',$userData->admin_username)->first();
        $fullfilled = 1;

        $bonus = Bonus::where([
            'status'=>1,
            'bonus_uid'=>$request->bonus_uid
        ])->first();
        $bonus_amount = $bonus->amount;

        if($bonus->type==0){
            $wager_amount = $bonus->wager_amount*10;
            $user_additional_data = json_decode($userData->additional_data,true);
            $user_additional_data['signUpBonusClaim'] = false;
            // $user_additional_data['signUpBonusClaim'] = $wager_amount;
            $userData->additional_data = json_encode($user_additional_data);
            // if($userData->win_amount < $wager_amount){
            //     $fullfilled = 0;
            // }
        } else if($bonus->type==1){
            if($userData->loss_amount < 50000){
                $fullfilled = 0;
            } else{
                $wager_amount = $bonus->wager_amount*10;
                if($userData->wager_amount < $wager_amount){
                    $fullfilled = 0;
                }
            }
        } else if($bonus->type==2){
            $wager_amount = json_decode($userData->bonus,true)[$request->bonus_uid]['amount']*10;
            if($userData->win_amount < $wager_amount){
                $fullfilled = 0;
            }
        } else if($bonus->type==3){
            $bonus_amount = json_decode($userData->bonus,true)[$request->bonus_uid]['amount'];
        } else{
            $bonus_amount = json_decode($userData->bonus,true)[$request->bonus_uid]['amount'];
        }

        // $wager_amount = $bonus->wager_amount;

        if(!$fullfilled){
            return response()->json([
                'message'=> 'Condition not fullfilled to claim this bonus',
                // 'message'=> $bonus->description,
                'response_code'=> '405'
            ]);
        } else{
            // add request to add amount in walletP
            // if($bonus->type == 2){

                $transaction = new Transaction();
                $transaction->username = $userData->username;
                $transaction->order_sn = 'BON_'.time().rand(0000,9999);
                $transaction->wallet_before = $userData->wallet_amount;
                $transaction->transfer_amount = $bonus_amount;
                $transaction->ip = $request->ip();
                $transaction->status = 2;
                $transaction->payment_type = 2;
                $transaction->currency = "INR";
                $transaction->remark = $bonus->description;
                $transaction->save();
                
                $bonuses = json_decode($userData->bonus,true);
                unset($bonuses[$request->bonus_uid]);
                $userData->bonus = json_encode($bonuses);
                // dd(json_encode($bonuses));
                $userData->wallet_amount += $bonus_amount;
                $userData->wager_amount -= $bonus_amount;
                $admin->wallet_amount -= $bonus_amount;
            // }
        }
        $userData->save();
        $admin->save();
        
        return response()->json([
            'message'=> 'You have successfully claimed the bonus',
            'response_code'=> '200'
        ]);
    }
    
    public function openBets(Request $request){
        // $openBets = SportookBet::where('username',$this->currentUser->username)->where('status',0)->orderBy('id','desc')->get();
        $openBets = SportookBet::where('username',$this->currentUser->username)->where('status',0)->orderBy('id','desc')->get();
        
        // $openBets = SportookBet::where('username',$this->currentUser->username)->whereIn('status',[1])->orderBy('id','desc')->get();

        // dd($openBets);
        if(count($openBets)){
            return response()->json([
                'response_code'=>'200',
                'data'=> $openBets
            ]);
        } else{
            return response()->json([
                'response_code'=>'401',
                'data'=> 'No Openbets Available'
            ]);
        }
    }

    public function eventBets(Request $request){
        if(isset($request->gtype)){

            if($request->gtype==0){
                $mname = ['MATCH_ODDS','Bookmaker','Tied Match','fancy1','Normal'];
            } else if($request->gtype==1){
                $mname = ['Normal'];
            }
            $openBets = SportookBet::where('username',$this->currentUser->username)->where('eventId',$request->eventId)->where('status',0)->whereIn('mname',$mname)->orderBy('id','desc')->get();

            $normalBets = SportookBet::where('username',$this->currentUser->username)->where('eventId',$request->eventId)->where('status',0)->whereIn('mname',['Normal'])->orderBy('id','desc')->get();

            if(count($openBets)){
                return response()->json([
                    'response_code'=>'200',
                    'data'=> $openBets,
                    'normalBets'=>count($normalBets)
                ]);
            } else{
            return response()->json([
                'response_code'=>'401',
                'data'=> 'No Openbets Available'
            ]);
        }
        } else{
            return response()->json([
                'response_code'=>'401',
                'data'=> 'No Openbets Available'
            ]);
        }
    }

    public function betlist(Request $request){
        
        $data = SportookBet::join('events','events.eventId','=','sportook_bets.eventId')->select('sportook_bets.*','events.eventName','events.sportname')->where('username',$this->currentUser->username)->orderBy('id','desc');

        if($request->sport != 'all'){
            $data = $data->where('sportname',$request->sport);
        }
        $bets = $data->get();
        
        $openBets = $data->get();
        // dd($openBets);
        
        $sattledBets = $data->get();

        // $bets = SportookBet::where('status',0)->get();
        return view('accounts.open_bets',compact('bets','openBets','sattledBets'));
    }

    public function live_game_bet_history(Request $request){
        
        $eventsExposure = SportookBet::where('username',$this->currentUser->username)->where('status',0);

        $bets = Event::joinSub($eventsExposure,'eventsExposure',function($join){
            $join->on('events.eventId','=','eventsExposure.eventId');
        })->orderBy('eventsExposure.id','desc')->get();

        return view('accounts.live_game_bet_history',compact('bets'));

    }

    public function account_statement(Request $request){
        
        $userData = User::getCurrentUser();

        $allTransactions = Transaction::where('username',$userData->username)->orderBy('id','desc')->get();

        $transactions = Transaction::where('username',$userData->username)->where('payment_type','<',2)->orderBy('id','desc')->get();

        $plTransactions = SportookBet::where('username',$this->currentUser->username)
        ->where('status','!=',0)
        ->select('eventId',\DB::raw('
        SUM(
            case
            when status=1 then profit
            else 0
            end
        ) as profit,
        SUM(
            case
            when status=2 then bet_amount
            else 0
            end
        ) as loss'),'created_at','status'
        )
        ->groupBy('eventId','created_at','status');
        // ->groupBy('eventId')
        // ->get();

        $plTransactions = Event::joinSub($plTransactions,'plTransactions',function($join){
            $join->on('events.eventId','=','plTransactions.eventId');
        })
        ->select('eventName',\DB::raw('SUM(profit) as profit,SUM(loss) as loss'),'plTransactions.created_at','plTransactions.status')
        ->groupBy('eventName','plTransactions.created_at','plTransactions.status')

        ->get();
        // dd($plTransactions);

        $bonusTransaction = Transaction::where('username',$userData->username)
        ->where('status','!=',1)
        ->where('payment_type',2)->orderBy('id','desc')->get();
        
        $bets = SportookBet::where('username',$this->currentUser->username)
        ->where('status','!=',0)
        ->select('eventId',\DB::raw('
        SUM(
            case
            when status=1 then profit
            else 0
            end
        ) as profit,
        SUM(
            case
            when status=2 then bet_amount
            else 0
            end
        ) as loss'),'created_at'
        )
        ->groupBy('eventId','created_at');
        // ->groupBy('eventId')
        // ->get();
        // dd($bets);

        $bets = Event::joinSub($bets,'bets',function($join){
            $join->on('events.eventId','=','bets.eventId');
        })
        ->select('sportname',\DB::raw('SUM(profit) as profit,SUM(loss) as loss'))
        ->groupBy('sportname')

        ->get();

        // dd($bets);

       
        return view('accounts.account_statement',compact('allTransactions','transactions','plTransactions','bonusTransaction','bets'));
    }

    public function transaction_history(Request $request){
        
        $userData = User::getCurrentUser();

        $allTransactions = Transaction::where('username',$userData->username)->orderBy('id','desc')->get();

        $transactions = Transaction::where('username',$userData->username)->where('status',1)->orderBy('id','desc')->get();

        $plTransactions = Transaction::where('username',$userData->username)->where('status',2)->orderBy('id','desc')->get();

        $bonusTransaction = Transaction::where('username',$userData->username)->where('status',0)->orderBy('id','desc')->get();

        return view('accounts.transaction_history',compact('allTransactions','transactions','plTransactions','bonusTransaction'));
    }

    public function profit_loss_event(Request $request){

        $bets = SportookBet::where('username',$this->currentUser->username)
        ->where('status','!=',0)
        ->select('eventId',\DB::raw('
        SUM(
            case
            when status=1 then profit
            else 0
            end
        ) as profit,
        SUM(
            case
            when status=2 then bet_amount
            else 0
            end
        ) as loss'),'created_at'
        )
        ->groupBy('eventId','created_at');
        // ->groupBy('eventId')

        // $bets = $bets->join('events','events.eventId','=','sportook_bets.eventId')
        // ->select('sportook_bets.eventId','eventName','profit','loss')
        // ->get();

        // dd($bets);

        $bets = Event::joinSub($bets,'bets',function($join){
            $join->on('events.eventId','=','bets.eventId');
        })
        ->select('bets.created_at','eventName','profit','loss')
        ->get();

        $activities = Activity::where('username',$this->currentUser->username)->orderBy('id','desc')->get();

        // dd($bets);
        
        return view('accounts.profit_loss_event',compact('bets','activities'));
    }

    public function referred_users(Request $request){
        
        $userData = User::getCurrentUser();
        $referrals = User::where('referral',$userData->username)->get();
        return view('accounts.referred_users',compact('referrals'));
    }

    public function userBalance(Request $request){
        $userData = User::getCurrentUser();
        // $user = User::where('username',$request->username)->get();
        return response()->json([
            'response_code'=>'200',
            'wallet_amount'=> $userData->wallet_amount,
            'unsattled_amount'=> $userData->unsattled_amount
        ]);
    }
}

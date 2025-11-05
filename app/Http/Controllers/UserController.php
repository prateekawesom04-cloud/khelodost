<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Bonus;
use App\Models\Payment;
use App\Models\UserBank;
use App\Models\SportookBet;

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
        $agent = User::where('username',$user->username)->where('status','>',0)->first();
        $data = Transaction::where([
            'username'=>$user->username,
            'payment_type'=>'0'
        ])->get();
        // $payments = Payment::where('admin_username',$user->admin_username)->get();
        return view('accounts.deposit',compact('data','agent'));

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
            'error_code'=> '200'
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
                $bonuses = json_decode($userData->bonus,true);
                unset($bonuses[$request->bonus_uid]);
                $userData->bonus = json_encode($bonuses);
                // dd(json_encode($bonuses));
                $userData->wallet_amount += $bonus_amount;
                $userData->wager_amount -= $bonus_amount;
            // }
        }
        $userData->save();
        
        return response()->json([
            'message'=> 'You have successfully claimed the bonus',
            'response_code'=> '200'
        ]);
    }

    public function addBank(Request $request){

        $rules = [
            'username'=>'required',
            'account_holder'=>'required',
            'account_number'=>'required|numeric',
            'confirm_account_number' => 'required|same:account_number',
            'bank_name'=>'required',
            'ifsc_code'=>'required|max:11',
            'upi_id'=>'required'
        ];

        
        $validator = Validator::make($request->all(), $rules);
        $errors = [];
        if($validator->fails()){
            foreach ($validator->errors()->messages() as $key => $value) {
                $errors[] = $value[0];
            }
            return response()->json([
                'message'=> $errors[0],
                'response_code'=> '305'
            ]);
            
        } else{

            $userBank = UserBank::where('username',$request->username)->first();
    
            if($userBank){
                $userBank->username = $request->username;
                $userBank->account_holder = $request->account_holder;
                $userBank->account_number = $request->account_number;
                $userBank->bank_name = $request->bank_name;
                $userBank->ifsc_code = $request->ifsc_code;
                $userBank->upi_id = $request->upi_id;
                $userBank->save();
            } else{
                $userBank = new UserBank();
                $userBank->username = $request->username;
                $userBank->account_holder = $request->account_holder;
                $userBank->account_number = $request->account_number;
                $userBank->bank_name = $request->bank_name;
                $userBank->ifsc_code = $request->ifsc_code;
                $userBank->upi_id = $request->upi_id;
                $userBank->save();
            }
    
            return response()->json([
                'message'=> 'Account Updated',
                'response_code'=> '200'
            ]);

        }

    }
    
    public function openBets(Request $request){
        $openBets = SportookBet::where('username',$this->currentUser->username)->whereIn('status',[1])->orderBy('id','desc')->get();

        // dd($openBets);
        if(count($openBets)){
            return response()->json([
                'code'=>'200',
                'data'=> $openBets
            ]);
        } else{
            return response()->json([
                'code'=>'401',
                'data'=> 'No Openbets Available'
            ]);
        }
    }

    public function betlist(Request $request){
        $bets = SportookBet::where('username',$this->currentUser->username)->get();
        $openBets = SportookBet::where('username',$this->currentUser->username)->where('status',0)->get();

        // $bets = SportookBet::where('status',0)->get();
        return view('accounts.open_bets',compact('bets','openBets'));
    }
}

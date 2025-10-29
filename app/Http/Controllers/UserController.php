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
        return view('accounts.withdrawal',compact('data'));

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
        return redirect('register');
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
        
        return view('accounts.bonus');
    }

    public function claimBonus(Request $request){

        $userData = $this->currentUser;
        $bonusData = $this->user_additional_data->bonusData;
        $user_bonus_wager = $bonusData->{$request->bonus_id}->wager_amount;

        $bonus = Bonus::where([
            'status'=>1,
            'bonus_uid'=>$request->bonus_id
        ])->first();

        $wager_amount = $bonus->wager_amount;

        if($user_bonus_wager < $wager_amount){
            return response()->json([
                'message'=> 'Please fulfill the wager',
                'response_code'=> '405'
            ]);
        } else{
            // add request to add amount in walletP
            // if($bonus->type == 2){
                $userData->wallet_amount += $bonus->amount;
            // }
        }
        return response()->json([
            'message'=> 'Bonus Amount added to your wallet',
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
}

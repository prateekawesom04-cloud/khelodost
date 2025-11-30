<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Bonus;
use App\Models\Transaction;
use App\Models\Activity;
use App\Models\Payment;
use App\Models\Appdata;
use App\Models\GameHistory;
use App\Models\SportookBet;
use App\Models\Event;

class AdminUserController extends Controller
{
    //
    
    public function checkMasterPassword($masterPassword){
            
        $user = User::getCurrentUser();
        if(!Hash::check($masterPassword,$user->password)){
            return false;
        }
        return true;
    }

    public function user_downline_list(Request $request,$username){
        // $users = User::where([
            // 'admin_username'=>$username,
        //     'status'=>2
        // ])->get();

        $users = User::where('status','!=',0)->get();

        return view('admin.pages.user_downline_list',compact('users'));
    }
    
    public function blockUser(Request $request){

        $user = User::where('username',$request->username)->first();
        $user->status = $request->status;
        $user->save();

        return response()->json([
            'message'=> 'User Status Updated',
            'response_code'=> '200'
        ]);
    }

    public function master_downline_list(Request $request){
        $admin = User::getCurrentUser();
        // dd($admin);
        $users = User::where([
            'username'=>$admin->username
        ])
        ->whereIn('status',[1,2,3,4])
        ->get();
        return view('admin.pages.master_downline_list',compact('users'));
    }

    public function add_user_client(Request $request){
        
        $rules = [
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ];
        
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            foreach ($validator->errors()->messages() as $key => $value) {
                $errors[] = $value[0];
            }
            return response()->json([
                'message'=> $errors[0],
                'response_code'=> '105'
            ]);
            
        }

        // $request->phone = $request->username;
        // $request->password = Hash::make($request->password);
        $request->merge(['password'=>Hash::make($request->password)]);
        $request->merge(['phone'=>$request->username]);
        $request->merge(['country_phone_code'=>'91']);
        $request->merge(['admin_username'=>'adminabcd']);

        if(!$this->checkMasterPassword($request->masterPassword)){
            return response()->json([
                'message'=> 'wrong master password',
                'response_code'=>'400'
            ]);
        }
        
        $existingUser = User::where('username', $request->username)->first();
        if($existingUser){
            return response()->json([
                'message'=> 'User Already Present',
                'response_code'=>'300'
            ]);
        }
        try {
            $user = new User();
            $tableName = (new User())->getTable();
            $columns = Schema::getColumnListing($tableName);
            array_splice($columns, 0, 1);
            array_splice($columns, count($columns)-2, 2);


            // foreach ($columns as $key => $value) {
            //     $user->{$value} = $request->{$value};
            // }

            foreach ($columns as $key => $value) {
                if(array_key_exists($value,$request->all())){
                    $user->{$value} = $request->{$value};
                // } else{
                //     $user->{$value} = NULL;
                }
            }
            
            $user->save();
        } catch(QueryException $e){
            if ($e->errorInfo[1] == 1062) {
                return response()->json([
                    'message'=> 'User Already Present',
                    'response_code'=>'300'
                ]);
            }
        }
        
        return response()->json([
            'message'=> 'User Created Successfully',
            'response_code'=>'200'
        ]);

    }
 
    public function my_account(Request $request){

        // $userData = User::getCurrentUser();
        $user = User::where('username',$request->username)->first();
        $activities = Activity::where('username',$request->username)->get();
        // $transactions = Transaction::where('username',$request->username)->orderBy('payment_type')->get();
        $transactions = Transaction::where('username',$request->username)->orderBy('id')->get();
        $sportbookBets = Event::join('sportook_bets','events.eventId','=','sportook_bets.eventId')
        ->select('sportook_bets.*','events.eventName','events.sportname')
        ->where('username',$request->username)
        // ->where('sportook_bets.status',0)
        ->orderBy('sportook_bets.id')->get();
        // $betStatment = $sportbookBets->where('status','!=',0)->get();
        
        return view('admin.pages.my_account',compact('user','activities','transactions','sportbookBets'));
    }
    
    public function updateUserPhone(Request $request){
        
        $rules = [
            'phone' => 'required|integer|digits:10',
        ];
        
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            foreach ($validator->errors()->messages() as $key => $value) {
                $errors[] = $value[0];
            }
            return response()->json([
                'message'=> $errors[0],
                'response_code'=> '105'
            ]);
            
        }

        if(!$this->checkMasterPassword($request->master_password)){
            return response()->json([
                'message'=> 'wrong master password',
                'response_code'=>'400'
            ]);
        }
        
        $user = User::where('username',$request->username)->first();
        $user->phone = $request->phone;
        $user->save();

        return response()->json([
            'message'=> 'Password Updated',
            'response_code'=>'200'
        ]);
    }
    
    public function updateUserPassword(Request $request){
        
        $rules = [
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ];
        
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            foreach ($validator->errors()->messages() as $key => $value) {
                $errors[] = $value[0];
            }
            return response()->json([
                'message'=> $errors[0],
                'response_code'=> '105'
            ]);
            
        }

        if(!$this->checkMasterPassword($request->master_password)){
            return response()->json([
                'message'=> 'wrong master password',
                'response_code'=>'400'
            ]);
        }
        
        $user = User::where('username',$request->username)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'message'=> 'Password Updated',
            'response_code'=>'200'
        ]);
    }
    
    public function updateWallet(Request $request){
        if(!$this->checkMasterPassword($request->master_password)){
            return response()->json([
                'message'=> 'wrong master password',
                'response_code'=>'400'
            ]);
        }
        $user = User::where('username',$request->username)->first();
        $wallet_before = $user->wallet_amount;
        if($request->payment_type == 0){
            $user->wallet_amount += $request->transfer_amount;
        } else{
            if($user->wallet_amount<$request->transfer_amount){
                return response()->json([
                    'message'=> 'User Balance is lower then withdraw amount',
                    'response_code'=>'401'
                ]);
            }
            $user->wallet_amount -= $request->transfer_amount;
        }
        $user->save();
        
        $transaction = new Transaction();
        $transaction->username = $request->username;
        $transaction->order_sn = "ADM_".time().rand(0000,9999);
        $transaction->wallet_before = $wallet_before;
        $transaction->transfer_amount = $request->transfer_amount;
        $transaction->ip = $request->ip();
        $transaction->status = 2;
        $transaction->payment_type = $request->payment_type;
        $transaction->manual = 1;
        $transaction->currency = "INR";
        $transaction->remark = $request->remark;
        $transaction->save();

        return response()->json([
            'message'=> 'Balance Updated Successfully',
            'response_code'=>'200'
        ]);
    }

}

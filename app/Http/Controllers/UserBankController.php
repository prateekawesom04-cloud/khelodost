<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserBank;
use App\Models\Transaction;

class UserBankController extends Controller
{
    //

    public function account_setting(Request $request){
        
        $user = User::getCurrentUser();
        $userBank = UserBank::where('username',$user->username)->first();
        return view('accounts.account_setting',compact('userBank'));
    }
    public function addBank(Request $request){

        $rules = [
            // 'username'=>'required',
            'account_holder'=>'required',
            // 'account_number'=>'required|numeric',
            'account_id'=>'required',
            'confirm_account_id' => 'required|same:account_id',
            'bank_name'=>'required',
            'ifsc_code'=>'required|max:11',
            // 'upi_id'=>'required'
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

            $user = User::getCurrentUser();
            $userBank = UserBank::where('username',$user->username)->first();
    
            if($userBank){
                // $userBank->username = $request->username;
                $userBank->account_holder = $request->account_holder;
                $userBank->account_id = $request->account_id;
                $userBank->bank_name = $request->bank_name;
                $userBank->ifsc_code = $request->ifsc_code;
                // $userBank->upi_id = $request->upi_id;
                $userBank->save();
            } else{
                $userBank = new UserBank();
                $userBank->username = $user->username;
                $userBank->account_holder = $request->account_holder;
                $userBank->account_id = $request->account_id;
                $userBank->bank_name = $request->bank_name;
                $userBank->ifsc_code = $request->ifsc_code;
                // $userBank->upi_id = $request->upi_id;
                $userBank->save();
            }
    
            return response()->json([
                'message'=> 'Account Updated',
                'response_code'=> '200'
            ]);

        }

    }
}

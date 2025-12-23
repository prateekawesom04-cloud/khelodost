<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\UserBank;
use App\Models\Transaction;

class PaymentController extends Controller
{
    //
    
    public function gateways(){
        // $user = User::getCurrentUser();
        // $payments = Payment::where('admin_username',$user->username)->get();
        $gateways = Payment::get();
        return view('admin.pages.gateways',compact('gateways'));
    }

    public function gatewayUpdate(Request $request){
        $gateway = Payment::where('id',$request->id)->first();
        $gateway->status = $gateway->status?0:1;
        $gateway->save();

        $gateways = Payment::where('id','!=',$request->id)->update(['status'=>0]);
        
        return response()->json([
            'message'=> 'Gateway Updated Successfully',
            'response_code'=> '200',
        ]);
    }

    public function userBankData(Request $request){
        $transaction = Transaction::where('order_sn',$request->order_sn)->first();
        $userBankData = UserBank::where('username',$transaction->username)->first();
        return response()->json([
            'userBankData'=>$userBankData,
            'transaction'=>$transaction,
            'response_code'=>200
        ]);
    }
}

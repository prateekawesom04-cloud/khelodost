<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

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

        $gateways = Payment::where('id','!=',$request->id)->update('status',0);
        
        return response()->json([
            'message'=> 'Gateway Updated Successfully',
            'response_code'=> '200',
        ]);
    }
}

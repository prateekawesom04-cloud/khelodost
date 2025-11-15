<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;

class TransactionController extends Controller
{
    //
    
    public function paymentGatewayMethod(Request $request){
        $data = [];

        $user = User::getCurrentUser();
        
        if($user){

            $transaction = new Transaction();
            $transaction->username = $user->username;
            $transaction->order_sn = $data['order_sn'];
            $transaction->wallet_before = $user->wallet_amount;
            $transaction->transfer_amount = $request->transfer_amount;
            $transaction->ip = $request->ip();
            $transaction->status = 1;
            $transaction->payment_type = $request->payment_type;
            $transaction->currency = "INR";
            $transaction->remark = "remark001";
            $transaction->save();
            
            if($request->payment_type == 0){
    
                $data['trade_type'] = 'INRUPI';
                $data['ip'] = $request->ip();
                $data['remark'] = "remark001";
            
            } elseif ($request->payment_type == 1) {
    
                // $data['currency'] = $request->currency;
                $data['currency'] = "INR";
                
            } else{
                return False;
            }
    

            $data['versionNo'] = env('versionNo');
            $data['mchNo'] = env('mchNo');
            $data['price'] = $request->transfer_amount;
            $data['orderDate'] = date(now(),'yyyyMMddHHmmss');
            $data['tradeNo'] = 'TR'.time().rand(0000,9999);
            $data['callbackUrl'] = env('APP_URL').'/payment/callback';
            $data['payType'] = $request->payment_type;
            // $data['encryptionKey'] = env('encryptionKey');
            // $data['signatureKey'] = env('signatureKey');

            $data['payload'] = json_encode($data);
            $data['payload'] = base64_encode($data['payload']);

            $data['sign'] = (new AuthController)->md5_sign($data, env('LG_PAY_SECRET_KEY'));
            
            $payment_type = ($request->payment_type==1) ? 'deposit' : 'order';
            
            $url = "https://www.lg-pay.com/api/".$payment_type."/create";
            
            $ch = curl_init();
    
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Content-Type: application/x-www-form-urlencoded"
            ]);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT);
            curl_setopt($ch, CURLOPT_TIMEOUT, 120);
    
            $response = curl_exec($ch);
    
            if (curl_errno($ch)) {
                return curl_error($ch);
            } 
    
            curl_close($ch);
            
            return response()->json([
                'message'=> 'Deposit Request Created Succesfully',
                'code'=> '200',
                'response'=>$response
            ]);
        } else{
            
            return response()->json([
                'message'=> 'login required',
                'code'=> '105'
            ]);

        }

    }
    
    public function paymentCallback(Request $request){

        $data =[];

        $data['order_sn'] = $request->order_sn;
        $data['money'] = $request->money;
        $data['status'] = $request->status;
        $data['pay_time'] = $request->pay_time;
        $data['msg'] = $request->msg;
        $data['remark'] = $request->remark;

        // $model = YourModel::findOrFail($id);
        // $model->fill(request()->all());
        // $model->save();

        $sign = md5_sign($data,env('LG_PAY_SECRET_KEY'));
        if($sign == $request->sign){
            $transaction = Transaction::where('order_sn',$request->order_sn);

            $transaction->transfer_amount = $request->money;
            $transaction->status = $request->status;
            $transaction->manual = 0;
            $transaction->save();

            return 'ok';
        } else{
            return 'no';
        }
    }
}

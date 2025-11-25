<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Transaction;

class TransactionController extends Controller
{
    //
    
    public function paymentGatewayMethod(Request $request){
        $user = User::getCurrentUser();

        $request->merge(['order_sn'=>'TR'.time().rand(0000,9999)]);
        $request->merge(['username'=>$user->username]);
        
        if($user){

            $transaction = new Transaction();
            $transaction->username = $user->username;
            $transaction->order_sn = $request->order_sn;
            $transaction->wallet_before = $user->wallet_amount;
            $transaction->transfer_amount = $request->transfer_amount;
            $transaction->ip = $request->ip();
            $transaction->status = 1;
            $transaction->payment_type = $request->payment_type;
            $transaction->currency = "INR";
            $transaction->remark = "remark001";
            $transaction->save();
            
            // Api statements

            $response = '3456';

            $apiData = [];

            if($user->country_phone_code == '91'){

                $apiData['mchNo'] = 'M0396';
                $apiData['encryptionKey'] = '72012C03A0F21CC3';
                $apiData['signatureKey'] = '613BA28576F3CDF8';
                $response = $this->paymentGatewayIndMethod($request);
            } else{
                $apiData['mchNo'] = 'M0402';
                $apiData['encryptionKey'] = '324AE62E4A0341B3';
                $apiData['signatureKey'] = '5D34BD894E07C2BE';
                $response = $this->paymentGatewayBanMethod($request);
            }
        } else{
            
            return response()->json([
                'message'=> 'login required',
                'response_code'=> '105'
            ]);

        }

        $response = $response->getData();
        $response = json_decode($response->response);

            // $payload = $response->payload;
            // $payload = (new AuthController)->aes128cbcDycrypt($apiData['encryptionKey'],$payload);
            // dd($payload);
        // dd($response);


        if($response->code == 0){
            $mchNo = $response->mchNo;
            $payload = $response->payload;
            $sign = $payload.$apiData['signatureKey']; // concatinating the payload and signature key
            $sign = strtoupper(md5($sign));
            // dd($response->sign,'-----',$sign);
            Log::info('gateway payload--');
            Log::info($response->payload);
            if($response->sign == $sign){
                // dd('if');
                $payload = (new AuthController)->aes128cbcDycrypt($apiData['encryptionKey'],$payload);
                Log::info('decrypted payload');
                Log::info($payload);
                return response()->json([
                    'data'=> $payload,
                    'response_code'=> '200'
                ]);
                // dd($payload);
            } else{
                // dd('else');
                return response()->json([
                    'message'=> 'Unable to verify Sign',
                    'response_code'=> '105'
                ]);
            }
        }
            

    }
    
    public function paymentGatewayIndMethod(Request $request){
        
        Log::info('paymentGatewayIndMethod');
        Log::info($request->all());
        $apiData = [];

        $apiData['mchNo'] = 'M0396';
        $apiData['encryptionKey'] = '72012C03A0F21CC3';
        $apiData['signatureKey'] = '613BA28576F3CDF8';
        
        $data = [];

        $data['versionNo'] = 1;
        $data['mchNo'] = $apiData['mchNo'];
        $data['price'] = $request->transfer_amount;
        // $data['orderDate'] = date('YmdHis');
        $data['orderDate'] = date('YmdHis');
        $data['tradeNo'] = $request->order_sn;
        $data['notifyUrl'] = env('APP_URL').'/paymentCallbackInd';

        if($request->payment_type == 0){

            $data['callbackUrl'] = env('APP_URL').'/deposit';
            $data['payType'] = '01';
            $data['payerName'] = $request->username;
            $data['payEmail'] = 'matchbhai@gmail.com';
            $data['payMobile'] = '9090099099';
        
        } elseif ($request->payment_type == 1) {

            $data['mode'] = S1;
            $data['accBankCode'] = $request->accBankCode;
            $data['accName'] = $request->accName;
            $data['accCardNo'] = $request->accCardNo;
            $data['purpose'] = $request->purpose;
            
        } else{
            return False;
        }

        
        $sdata = [];

        $sdata['payload'] = json_encode($data);

        // dd(json_encode($data));

        $sdata['payload'] = (new AuthController)->aes128cbc($apiData['encryptionKey'],$sdata['payload']);

        $sdata['sign'] = $sdata['payload'].$apiData['signatureKey'];
        
        $sdata['sign'] = strtoupper(md5($sdata['sign']));
        
        $sdata['mchNo'] = $data['mchNo'];
        
        // dd($sdata['payload']);
        // $data['sign'] = (new AuthController)->md5_sign($data, env('signatureKey'));
        
        // dd($sdata);

        $sdata = json_encode($sdata);
        
        $payment_type = ($request->payment_type==1) ? 'transferApply' : 'makeOrder';
        
        // $url = "https://www.lg-pay.com/api/".$payment_type."/create";

        // $url = env('paying_url')."/".$payment_type;

        $url = 'https://phpay.ipayment.vip/dgateway/ws/trans/nocard/'.$payment_type;
        
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $sdata);
        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return curl_error($ch);
        } 

        curl_close($ch);
        // dd($response);
        return response()->json([
            'message'=> 'Deposit Request Created Succesfully',
            'response_code'=> '200',
            'response'=>$response
        ]);

    }

    public function paymentGatewayBanMethod(Request $request){
        
        // dd($request->all());
        Log::info('paymentGatewayBanMethod');
        Log::info($request->all());
        $apiData = [];

        $apiData['mchNo'] = 'M0402';
        $apiData['encryptionKey'] = '324AE62E4A0341B3';
        $apiData['signatureKey'] = '5D34BD894E07C2BE';
        
        $data = [];

        $data['versionNo'] = 1;
        $data['mchNo'] = $apiData['mchNo'];
        $data['price'] = $request->transfer_amount;
        $data['orderDate'] = date('YmdHis');
        $data['tradeNo'] = $request->order_sn;
        $data['notifyUrl'] = env('APP_URL').'/paymentCallbackBan';

        if($request->payment_type == 0){

            $data['callbackUrl'] = env('APP_URL').'/deposit';
            $data['payType'] = '01';
            $data['channelPayType'] = 'EWALLET_BKASH';
        
        } elseif ($request->payment_type == 1) {

            $data['mode'] = S1;
            $data['accBankCode'] = $request->accBankCode;
            $data['accName'] = $request->accName;
            $data['accCardNo'] = $request->accCardNo;
            $data['purpose'] = $request->purpose;
            
        } else{
            return False;
        }

        
        $sdata = [];

        $sdata['payload'] = json_encode($data);

        $sdata['payload'] = (new AuthController)->aes128cbc($apiData['encryptionKey'],$sdata['payload']);

        $sdata['sign'] = $sdata['payload'].$apiData['signatureKey'];
        
        $sdata['sign'] = strtoupper(md5($sdata['sign']));
        
        $sdata['mchNo'] = $data['mchNo'];
        
        // dd($sdata['payload']);
        // $data['sign'] = (new AuthController)->md5_sign($data, env('signatureKey'));
        
        // dd($sdata);

        $sdata = json_encode($sdata);
        
        $payment_type = ($request->payment_type==1) ? 'transferApply' : 'makeOrder';
        
        // $url = "https://www.lg-pay.com/api/".$payment_type."/create";

        // $url = env('paying_url')."/".$payment_type;

        $url = 'https://phpay.ipayment.vip/dgateway/ws/trans/nocard/'.$payment_type;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $sdata);
        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return curl_error($ch);
        } 

        curl_close($ch);
        
        // dd($response);
        return response()->json([
            'message'=> 'Deposit Request Created Succesfully',
            'response_code'=> '200',
            'response'=>$response
        ]);

    }

    
    public function paymentCallback(Request $request){

        Log::info('payement callack----');
        Log::info($request->all());
        
        $transaction = Transaction::where('order_sn',$request->tradeNo);

        
        if($transaction){

            $transaction->transfer_amount = $request->money;
            $transaction->status = 2;
            $transaction->save();

            $user = User::where('username',$transaction->username)->first();
            $user->wallet_amount = $user->wallet_amount + $request->price;
            $user->save();
        } else{
            return response()->json([
                'message'=> 'Transaction not found',
                'response_code'=> '105'
            ]);
        }

    }

    public function paymentCallbackInd(Request $request){

        Log::info('payement callack--Ind--');
        Log::info('payement callack--Ind-- Request--');
        Log::info($request->all());
        Log::info('payload---'.$request->payload);
        $apiData['mchNo'] = 'M0396';
        $apiData['encryptionKey'] = '72012C03A0F21CC3';
        $apiData['signatureKey'] = '613BA28576F3CDF8';

        if($request->code == 0){
            $payload = $request->payload;
            
            $sign = $payload.$apiData['signatureKey']; // concatinating the payload and signature key
            
            $sign = strtoupper(md5($sign));
            Log::info('$sign');
            Log::info($sign);
            Log::info('$request->sign');
            Log::info($request->sign);
            if($request->sign == $sign){
                Log::info('payement callack--Ind--payment--success--');
                $payload = (new AuthController)->aes128cbcDycrypt($apiData['encryptionKey'],$payload);

                $payload = json_decode($payload);

                $callbackData = new Request();

                $callbackData->merge($payload);

                $this->paymentCallback($callbackData);
            }

        }
    }
    
    public function paymentCallbackBan(Request $request){
        
        Log::info('payement callack--Ban--');
        Log::info('payement callack--Ban-- Request--');
        Log::info($request->all());
        Log::info('payload---'.$request->payload);
        $apiData['mchNo'] = 'M0402';
        $apiData['encryptionKey'] = '324AE62E4A0341B3';
        $apiData['signatureKey'] = '5D34BD894E07C2BE';

        if($request->code == 0){
            $payload = $request->payload;
            
            $sign = $payload.$apiData['signatureKey']; // concatinating the payload and signature key
            
            $sign = strtoupper(md5($sign));

            if($request->sign == $sign){
                Log::info('payement callack--Ban--payment--success--');
                $payload = (new AuthController)->aes128cbcDycrypt($apiData['encryptionKey'],$payload);

                $payload = json_decode($payload);

                $callbackData = new Request();

                $callbackData->merge($payload);

                $this->paymentCallback($callbackData);
            }

        }
    }

    public function updateTransaction(Request $request){
        $transaction = Transaction::where('order_sn',$request->order_sn)->first();
        $transaction->{$request->updateKey} = $request->{$request->updateKey};
        $transaction->save();

        return response()->json([
            'message'=> 'Transaction Updated Successfully',
            'response_code'=> '200'
        ]);
    }
}

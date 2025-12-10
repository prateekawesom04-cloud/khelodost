<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\UserBank;
use App\Models\Transaction;

class TransactionController extends Controller
{
    //
    
    public function withdrawalRequest(Request $request){

        $user = User::getCurrentUser();

        if($user->wallet_amount < $request->transfer_amount){
            return response()->json([
                'message'=> 'Amount Unvailable in your wallet',
                'response_code'=> '105'
            ]);
        }
        
        $oldTransaction = Transaction::where('username',$user->username)->where('payment_type',0)->where('status',2)->sum('transfer_amount');
        // dd($oldTransaction);
        if(!$oldTransaction || $oldTransaction <500){
            return response()->json([
                'message'=> 'To withdraw amount you need minimum 1 deposit with amount of 500',
                'response_code'=> '105'
            ]);
        }

        $transaction = new Transaction();
        $transaction->username = $user->username;
        $transaction->order_sn = 'REQ_'.time().rand(0000,0000);
        $transaction->wallet_before = $user->wallet_amount;
        $transaction->transfer_amount = $request->transfer_amount;
        $transaction->ip = $request->ip();
        $transaction->status = 1;
        $transaction->payment_type = $request->payment_type;
        $transaction->currency = "INR";
        $transaction->remark = "Withdraw Request for ".$request->transfer_amount;
        $transaction->save();

        return response()->json([
            'message'=> 'Withdraw Request Created Successfully',
            'response_code'=> '200'
        ]);
    }
    
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
            $transaction->remark = "Deposit of ".$request->transfer_amount;
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


        if(isset($response->code) && $response->code == 0){
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
                $payloadData = json_decode($payload);
                return response()->json([
                    'data'=> $payload,
                    'message'=>$payloadData->statusDesc,
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
        } else{
            return response()->json([
                'message'=> 'Something Went Wrong',
                'response_code'=> '105'
            ]);
        }
            

    }
     
    public function paymentGatewayWithdrawMethod(Request $request){
        $user = User::getCurrentUser();
        // $transaction = Transaction::where
        
        if($user){
            
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


        if(isset($response->code) && $response->code == 0){
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
                $payloadData = json_decode($payload);
                return response()->json([
                    'data'=> $payload,
                    'message'=>$payloadData->statusDesc,
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
        } else{
            return response()->json([
                'message'=> 'Something Went Wrong',
                'response_code'=> '105'
            ]);
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

            $data['mode'] = 'S1';
            $data['accCardNo'] = $request->account_id;
            $data['accBankCode'] = $request->ifsc_code;
            $data['accName'] = $request->account_holder;
            $data['accTel'] = '9090099099';
            $data['accEmail'] = 'matchbhai@gmail.com';
            $data['purpose'] = $request->remark;
            
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
        // dd($request->transfer_amount);
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
            'message'=> 'Transaction Request Created Succesfully',
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
            'message'=> 'Transaction Request Created Succesfully',
            'response_code'=> '200',
            'response'=>$response
        ]);

    }

    
    public function paymentCallback(Request $request){

        Log::info('payement callack----');
        Log::info($request->all());
        
        if($request->status != '00'){
            Log::info($request->status.'--status---payement callack transaction failed----');
            return response()->json([
                'message'=> 'Transaction Failed',
                'response_code'=> '105'
            ]);
        }
        $transaction = Transaction::where('order_sn',$request->tradeNo)->where('status',1)->first();
        Log::info('$request->tradeNo--'.$request->tradeNo);
        Log::info('$transaction--');
        Log::info(json_decode(json_encode($transaction),true));
        
        if($transaction){
            Log::info('$transaction- done-');

            $transaction->transfer_amount = $request->price;
            $transaction->status = 2;
            $transaction->save();

            $user = User::where('username',$transaction->username)->first();

            if($transaction->payment_type != 1){
                $user->wallet_amount = floatval($user->wallet_amount) + floatval($request->price);
                $user->save();
            } else{
                $user->wallet_amount = floatval($user->wallet_amount) - floatval($request->price);
                $user->save();
            }


            return response()->json([
                'message'=> 'Transaction Successfull',
                'response_code'=> '200'
            ]);
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

        $request->payload = str_replace(' ','+',$request->payload);
        Log::info('payload- replaced spaces--'.$request->payload);
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

                Log::info('payload- replaced dycrypted--'.$payload);
                $payload = json_decode($payload,true);
                Log::info('payload-  dycrypted json_decode--');
                Log::info($payload);

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

        $request->payload = str_replace(' ','+',$request->payload);
        Log::info('payload- replaced spaces--'.$request->payload);
        if($request->code == 0){
            $payload = $request->payload;
            
            $sign = $payload.$apiData['signatureKey']; // concatinating the payload and signature key
            
            $sign = strtoupper(md5($sign));
            Log::info('$sign');
            Log::info($sign);
            Log::info('$request->sign');
            Log::info($request->sign);

            if($request->sign == $sign){
                Log::info('payement callack--Ban--payment--success--');
                $payload = (new AuthController)->aes128cbcDycrypt($apiData['encryptionKey'],$payload);

                Log::info('payload- replaced dycrypted--'.$payload);
                $payload = json_decode($payload,true);
                Log::info('payload-  dycrypted json_decode--');
                Log::info($payload);

                $callbackData = new Request();

                $callbackData->merge($payload);

                $this->paymentCallback($callbackData);
            }

        }
    }

    public function updateTransaction(Request $request){
        $transaction = Transaction::where('order_sn',$request->order_sn)->first();

        // return $this->lgPaymentGatewayMethod($request);

        if($request->status == 2){
            
            $user = User::where('username',$transaction->username)->first();

            $userBank = UserBank::where('username',$user->username)->first();

            if($transaction->payment_type != 1){
                $user->wallet_amount = floatval($user->wallet_amount) + floatval($transaction->transfer_amount);
            } else{
                
                $request->merge(['username'=>$user->username]);
                $request->merge([
                    'account_id'=>$userBank->account_id,
                    'ifsc_code'=>$userBank->ifsc_code,
                    'account_holder'=>$userBank->account_holder,
                    'remark'=>$transaction->remark,
                    'transfer_amount'=>$transaction->transfer_amount,
                    'payment_type'=>$transaction->payment_type
                ]);

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
                
                $response = $response->getData();
                $response = json_decode($response->response);
                // dd($response);
                if(isset($response->code) && $response->code == 0){
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
                        // dd('payload--',$payload);
                        $payloadData = json_decode($payload);
                        return response()->json([
                            'data'=> $payload,
                            'message'=>$payloadData->statusDesc,
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
                } else{

                    $response =  $this->transferQueryIndMethod($request);

                    if($response){
                        $user->wallet_amount = floatval($user->wallet_amount) - floatval($transaction->transfer_amount);
                    } else{
                        return response()->json([
                            'message'=> 'transaction in Process, please try again in sometime.',
                            'response_code'=> '105'
                        ]);
                    }
                }
            }
            $user->save();
        }
        $transaction->status = $request->status;
        $transaction->save();

        return response()->json([
            'message'=> 'Transaction Updated Successfully',
            'response_code'=> '200'
        ]);
    }

    public function transferQueryIndMethod(Request $request){
        
        Log::info('transferQueryIndMethod');
        Log::info($request->all());
        $apiData = [];

        $apiData['mchNo'] = 'M0396';
        $apiData['encryptionKey'] = '72012C03A0F21CC3';
        $apiData['signatureKey'] = '613BA28576F3CDF8';
        
        $data = [];

        $data['versionNo'] = 1;
        $data['mchNo'] = $apiData['mchNo'];
        $data['tradeNo'] = $request->order_sn;

        $sdata = [];

        $sdata['payload'] = json_encode($data);

        // dd(json_encode($data));

        $sdata['payload'] = (new AuthController)->aes128cbc($apiData['encryptionKey'],$sdata['payload']);

        $sdata['sign'] = $sdata['payload'].$apiData['signatureKey'];
        
        $sdata['sign'] = strtoupper(md5($sdata['sign']));
        
        $sdata['mchNo'] = $data['mchNo'];
        $sdata['tradeNo'] = $data['tradeNo'];

        $sdata = json_encode($sdata);
        
        $payment_type = ($request->payment_type==1) ? 'transferQuery' : 'orderQuery';
        // dd($payment_type);
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
        
        $response = json_decode($response);

        if(isset($response->code) && $response->code == 0){
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
                // dd('payload--',$payload);
                return $payload;
                $payloadData = json_decode($payload);

                if($payloadData->status =='00'){
                    // $user->wallet_amount = floatval($user->wallet_amount) - floatval($transaction->transfer_amount);
                    return True;
                    return response()->json([
                        'message'=> 'Transaction Successfull',
                        'response_code'=> '200'
                    ]);
                } else{
                    return False;
                }

                // return response()->json([
                //     'data'=> $payload,
                //     'message'=>$payloadData->statusDesc,
                //     'response_code'=> '200'
                // ]);
                // dd($payload);
            } else{
                // dd('else');
                return False;
                return response()->json([
                    'message'=> 'Unable to verify Sign',
                    'response_code'=> '105'
                ]);
            }
        } else{
            return False;
            return response()->json([
                'message'=> 'Something Went Wrong',
                'response_code'=> '105'
            ]);
        }
        // dd($response);
        return response()->json([
            'message'=> 'Transaction Succesfull',
            'response_code'=> '200',
            'response'=>$response
        ]);

    }

    // LG Payment Gateway
    public function lgPaymentGatewayMethod(Request $request){
        
        $data = [];
        $data['app_id'] = env('LG_PAY_APP_ID');
        $data['order_sn'] = "PRQ_".time().rand(0000,9999);
        $data['money'] = $request->transfer_amount*100;
        $data['notify_url'] = env('APP_URL').'/lgPaymentCallback';


    
            // if(session('user_uid')){}
            
        if($request->payment_type == 0){
            $user = User::getCurrentUser();

            if(!$user){

                return response()->json([
                    'message'=> 'login required',
                    'response_code'=> '105'
                ]);
            }
            
            // if($user){
            $transaction = new Transaction();
            $transaction->username = $user->username;
            // $transaction->user_uid = '121';
            $transaction->order_sn = $data['order_sn'];
            $transaction->wallet_before = $user->wallet_amount;
            $transaction->transfer_amount = $request->transfer_amount;
            $transaction->ip = $request->ip();
            $transaction->status = 1;
            $transaction->payment_type = $request->payment_type;
            $transaction->manual = 1;
            $transaction->currency = "INR";
            $transaction->remark = "Deposit of ".$request->transfer_amount;
            $transaction->save();

            $data['trade_type'] = 'INRUPI';
            $data['ip'] = $request->ip();
            $data['remark'] = "Deposit of ".$request->transfer_amount;
        
        } elseif ($request->payment_type == 1) {
            $data['order_sn'] = $request->order_sn;
            $transaction = Transaction::where('order_sn',$request->order_sn)->first();
            $user = User::where('username',$transaction->username)->first();
            $userBank = UserBank::where('username',$user->username)->first();
            // $data['currency'] = $request->currency;
            $data['currency'] = "INR";
            
            $bdata = [
                'name'=>$userBank->account_holder,
                'bank_name'=>$userBank->ifsc_code,
                'card_number'=>$userBank->account_id,
                'addon1'=>$userBank->ifsc_code,
            ];
            $data = array_merge($data,$bdata);
            
        } else{
            return False;
        }
    
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
        // dd(json_decode($response));
        return response()->json([
            'message'=> 'Transaction Request Created Succesfully',
            'response_code'=> '200',
            'response'=>$response
        ]);


    }  
    
    public function lgpayUpdateTransaction(Request $request){

        $response = $this->lgPaymentGatewayMethod($request);
    }
    
    public function lgPaymentCallback(Request $request){
        Log::info('lpayment callack----');
        Log::info($request->all());

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
        if($request->status == 1 && $sign == $request->sign){
            $transaction = Transaction::where('order_sn',$request->order_sn)->where('status',1)->first();

            $user = User::where('username',$transaction->username)->first();
            // $userBank = UserBank::where('username',$user->username)->first();

            if($transaction->payment_type != 1){
                $user->wallet_amount = floatval($user->wallet_amount) + floatval($transaction->transfer_amount);
            } else{
                
                $request->merge(['username'=>$user->username]);
                $request->merge([
                    'card_number'=>$userBank->account_id,
                    'bank_name'=>$userBank->ifsc_code,
                    'addon1'=>$userBank->ifsc_code,
                    'name'=>$userBank->account_holder
                ]);

                // Api statements

                $user->wallet_amount = floatval($user->wallet_amount) - floatval($transaction->transfer_amount);
                $response = '3456';
            }
            $transaction->transfer_amount = $request->transfer_amount;
            $transaction->status = 2;
            // $transaction->manual = 0;
            $transaction->save();

            return 'ok';
        } else{
            return 'no';
        }
    }
}

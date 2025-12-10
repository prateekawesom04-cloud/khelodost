<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Admin\AdminDataController;
use App\Models\User;
use App\Models\Bonus;
use App\Models\Activity;

class AuthController extends Controller
{
    //
    public function social()
    {
        return Socialite::driver('google')->redirect();
    }
    
    public function callback(Request $request){

        try {
            $user = Socialite::driver($request->redirect)->user();
            $request = new Request();
            $request->email = $user->email;

            $redirect = json_decode($this->signin($request)->getContent());
            return redirect($redirect->redirect);
        } catch (Throwable $e) {
            return redirect('/')->with('error', 'Google authentication failed.');
        }
    }

    public function setUserSession($value){
        // $user = User::where('username',$value)->first();
        // $activity = new Activity();
        // $activity->username = $user->username;
        // $activity->ip = $request->ip();
        // $activity->save();
        Session::put([
            'username'=>$value
        ]);
    }

    public function signin(Request $request){
        
        $rules = [
            'phone' => 'numeric|digits:10',
            'password' => 'min:6',
            'confirm_password' => 'same:password',
        ];
        
        $validator = Validator::make($request->all(), $rules);
        $errors = [];
        $username = rand(100,999).substr(time(),strlen(time())-4).rand(00,99);

        if($validator->fails()){
            foreach ($validator->errors()->messages() as $key => $value) {
                $errors[] = $value[0];
            }
            return response()->json([
                'message'=> $errors[0],
                'response_code'=> '405'
            ]);
            
        } else{
            $userAdditional = [];
            if($request->phone){
                $user = User::where('phone',$request->phone)->first();
                if(!$user){
                    $user = new User();
                    $user->username = $request->phone;
                    $user->admin_username = 'adminabcd';
                    $user->phone = $request->phone;
                    $user->password = Hash::make($request->password);
                    $user->referral_code = rand(100000,999999);
                    $user->country_phone_code = $request->country_phone_code;

                    $bonuses = json_decode($user->bonus,true);

                    $bonus = Bonus::where('type',0)->first();
                    $bonus_uid = Bonus::where('type',0)->first()->bonus_uid;
                    // $bonuses[$bonus_uid] = $this->addBonus($bonus_uid);
                    $bonuses[$bonus_uid]['bonus_uid'] = $bonus_uid;
                    $bonuses[$bonus_uid]['amount'] = $bonus->amount;
                    // dump('$bonuses----',$bonuses);
                    // dd(json_encode($bonuses));
                    $user->bonus = json_encode($bonuses);
                    
                    if($request->age_confirm){
                        $userAdditional['age_confirm'] = 1;
                        $user->additional_data = json_encode($userAdditional);
                    } else{
                        return response()->json([
                            'message'=> 'please confirm your age',
                            'response_code'=> '405'
                        ]);
                    }
                    
                    
                    $user->save();
                } else{
                    return response()->json([
                        'message'=> 'Already Registered',
                        'response_code'=> '405',
                    ]);
                }
                
                $this->setUserSession($user->username);
                $activity = new Activity();
                $activity->username = $user->username;
                $activity->ip = $request->ip();
                $activity->save();
            
            } else if($request->email){
                
                $user = User::where('email',$request->email)->first();
                if(!$user){
                    $user = new User();
                    $user->username = $request->email;
                    $user->admin_username = 'adminabcd';
                    $user->email = $request->email;
                    $user->referral_code = rand(100000,999999);
                    
                    $bonuses = json_decode($user->bonus,true);

                    $bonus = Bonus::where('type',0)->first();
                    $bonus_uid = Bonus::where('type',0)->first()->bonus_uid;
                    // $bonuses[$bonus_uid] = $this->addBonus($bonus_uid);
                    $bonuses[$bonus_uid]['bonus_uid'] = $bonus_uid;
                    $bonuses[$bonus_uid]['amount'] = $bonus->amount;
                    $user->bonus = json_encode($bonuses);

                    if($request->age_confirm){
                        $userAdditional['age_confirm'] = $request->age_confirm;
                        $user->additional_data = json_encode($userAdditional);
                    }
                    $user->save();
                }
                $this->setUserSession($user->username);
                $activity = new Activity();
                $activity->username = $user->username;
                $activity->ip = $request->ip();
                $activity->save();
            } else{
                return response()->json([
                    'message'=> 'please provide username',
                    'response_code'=> '404'
                ]);
            }

            // Referral Part
            if($request->referral_code){
                $user = User::where('username',$username)->first();
                $referralUser = User::where('referral_code',$request->referral_code)->first();
                if($referralUser){
                    $referralUser->referral_nos += 1;
                    $bonuses = json_decode($referralUser->bonus,true);

                    $bonus = Bonus::where('type',3)->first();
                    $bonus_uid = Bonus::where('type',3)->first()->bonus_uid;
                    // $bonuses[$bonus_uid] = $this->addBonus($bonus_uid);
                    $bonuses[$bonus_uid]['bonus_uid'] = $bonus_uid;
                    $bonuses[$bonus_uid]['amount'] = $bonus->amount;
                    $referralUser->bonus = json_encode($bonuses);

                    $referralUser->save();
                    
                    $user->referral = $referralUser->username;
                    $user->save();
                }
            }

            return response()->json([
                'message'=> 'Sign In Successfully',
                'response_code'=> '200',
                'redirect'=>route('index')
            ]);

        }
        
    }

    public function login(Request $request){
        // dd('request',$request);
        // return response()->json($request);
        if($request->phone){
            $user = User::where('phone',$request->phone)->whereIn('status',[1,2])->first();

        }

        if(empty($user)){
            return response()->json([
                'message'=> 'User not found or blocked, please contact support',
                'response_code'=> '104'
            ]);
        } else{
            if(Hash::check($request->password,$user->password)){
                Session::put([
                    'username'=>$user->username
                ]);
                $activity = new Activity();
                $activity->username = $user->username;
                $activity->ip = $request->ip();
                $activity->save();
                
            } else{
                return response()->json([
                    'message'=> 'Wrong Password',
                    'response_code'=> '105'
                ]);
            }
        }
        
        // $activity = new Activity();
        // $activity->username = $user->username;
        // $activity->ip = $request->ip();
        // $activity->login_status = 1;
        // $activity->save();
        return response()->json([
            'message'=> 'Login Successfully',
            'response_code'=> '200',
            'redirect'=>route('index')
        ]);
    }


    public function forgetPassword(Request $request){
        // dd($request->all());
        $rules = [
            'phone' => 'required|numeric|digits:10',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ];
        
        $validator = Validator::make($request->all(), $rules);
        $errors = [];
        if($validator->fails()){
            foreach ($validator->errors()->messages() as $key => $value) {
                $errors[] = $value[0];
            }
            return response()->json([
                'message'=> $errors[0],
                'response_code'=> '105'
            ]);
        } else{
            $user = User::where([
                'phone'=>$request->phone
            ])->first();
            $user->password = Hash::make($request->password);
            $user->save();
            
            return response()->json([
                'message'=> 'password updated successfully',
                'response_code'=> '200',
                'redirect'=>route('login')
            ]);
            
        }

    }

    public function changePassword(Request $request){
        dd($request->all());
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

    // public function getOtp(Request $request){

    //     $otp = random_int(100000, 999999);

    //     Session::put('user_otp_'.$request->phone,$otp);
    //     Session::put('otp_expiry_time',time() + (60));

    //     $data = [
    //         'APIKey'=>env('SMS_API_KEY'),
    //         // 'user'=>'awesomecart',
    //         // 'password'=>'Awesomecart@612',
    //         'senderid'=>'AWSMCT',
    //         'channel'=>'Trans',
    //         'DCS'=>0,
    //         'flashsms'=>0,
    //         'number'=>$request->phone,
    //         'text'=>'Your OTP is '.$otp.'. This code is valid for the next 10 min. Please enter it on the website/app for login AWESOMCART. Regards, AWSMCT',
    //         'route'=>'2',
    //         'peid'=>'1701169875173062064',
    //         'DLTTemplateId'=>'1707174046951830675'
    //     ];

    //     $string = http_build_query($data);

    //     $smsUrl = "http://bulksms.actinnsol.com/api/mt/SendSMS?".$string;

    //     $ch = curl_init();
        
    //     curl_setopt($ch, CURLOPT_URL, $smsUrl);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $response = curl_exec($ch);
    //     if (curl_errno($ch)) {
    //         echo 'cURL Error: ' . curl_error($ch);
    //     }
    //     curl_close($ch);

    //     return response()->json([
    //         'phone'=>$request->phone,
    //         'smsResponse'=>$response
    //     ]);
    // }
    
    public function getOtp(Request $request){
        
        // if($request->otptype == 'login'){
            // $user = User::where([
            //     'username'=>$request->phone
            // ])->first();
            
            // if(!$user){
            //     return response()->json([
            //         'message'=> 'User not found',
            //         'response_code'=> '104'
            //     ]);
            // }
        // }
        
        $otp = random_int(100000, 999999);

        Session::put('user_otp_'.$request->phone,$otp);
        Session::put('otp_expiry_time_'.$request->phone,time() + (60));

        $data = [
            'APIKey'=>env('SMS_API_KEY'),
            // 'user'=>'awesomecart',
            // 'password'=>'Awesomecart@612',
            'senderid'=>'AWSMCT',
            'channel'=>'Trans',
            'DCS'=>0,
            'flashsms'=>0,
            'number'=>$request->phone,
            'text'=>'Your OTP is '.$otp.'. This code is valid for the next 10 min. Please enter it on the website/app for login AWESOMCART. Regards, AWSMCT',
            'route'=>'2',
            'peid'=>'1701169875173062064',
            'DLTTemplateId'=>'1707174046951830675'
        ];

        $string = http_build_query($data);
        // dd($string);
        $smsUrl = "http://bulksms.actinnsol.com/api/mt/SendSMS?".$string;

        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $smsUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
        }
        curl_close($ch);

        return response()->json([
            'phone'=>$request->phone,
            'response'=>$response,
            'response_code'=>'200'
        ]);
    }

    public function verifyOtp(Request $request){
        if (time() < session('otp_expiry_time_'.$request->phone)){
            if($request->otp == Session::get('user_otp_'.$request->phone)){
                Session::put([
                    'user_otp_'.$request->phone.'verified'=>True
                ]);
                return response()->json([
                    'message'=> 'otp matched',
                    'response_code'=>200
                ]);
            } else{
                return response()->json([
                    'message'=> 'otp mismatched',
                    'response_code'=>101
                ]);
            }
        }
        return response()->json([
            'message'=> 'otp expired',
            'response_code'=>101
        ]);
    }

    public function demoLogin(){
        Session::put(['user_session'=>'demo_user_demo']);
        return redirect()->route('index');
    }

    public function validateData($data) {
        $data = [
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password
        ];
        
    }




    // -----------------------------------
    // Additional authentication functions
    // -----------------------------------

    
	public function generate_jwt($headers, $payload, $secret = 'testing_jwt') {
		$headers_encoded = base64url_encode(json_encode($headers));
		
		$payload_encoded = base64url_encode(json_encode($payload));
		
		$signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", $secret, true);
		$signature_encoded = base64url_encode($signature);
		
		$jwt = "$headers_encoded.$payload_encoded.$signature_encoded";
		
		return $jwt;
	}

    public function is_jwt_valid($jwt, $secret = 'testing_jwt') {
		
		$res = [
			'status' => '',
			'payload' => '',
		];

		$tokenParts = explode('.', $jwt);
		$header = base64_decode($tokenParts[0]);
		$payload = base64_decode($tokenParts[1]);
		$signature_provided = $tokenParts[2];

		$base64_url_header = base64url_encode($header);
		$base64_url_payload = base64url_encode($payload);
		$signature = hash_hmac('SHA256', $base64_url_header . "." . $base64_url_payload, $secret, true);
		$base64_url_signature = base64url_encode($signature);

		$is_signature_valid = ($base64_url_signature === $signature_provided);
		
		if (!$is_signature_valid) {
			$res['status']='Failed';
		} else {
			$res['status']='Success';
			$res['payload']=json_decode($payload, 1);
		}
		
		$allvalue = json_encode($res);
		
		return $allvalue;
	}
	
	public function base64url_encode($str) {
		return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
	}

    public function aes256Encrypt($secret_key,$string){
        $cipher = "AES-256-CBC";
        $key = hash('sha256', $secret_key);
        $iv = substr($key, 0, 16);
		$output = openssl_encrypt($string, $cipher, $key, 0, $iv);
		$output = base64_encode($output);
        return $output;
    }
    
    public function aes256Decrypt($secret_key,$string){
        $cipher = "AES-256-CBC";
        $key = hash('sha256', $secret_key);
        $iv = substr($key, 0, 16);
		$output = openssl_decrypt(base64_decode($string), $cipher, $key, 0, $iv);
        return $output;
    }

    public function aes128cbc($secret_key,$string){
        $method = "AES-128-CBC";
        // $iv_length = openssl_cipher_iv_length($method);
        // $iv = openssl_random_pseudo_bytes($iv_length);
        $iv = '0102030405060708';
        $encrypted = openssl_encrypt($string, $method, $secret_key, OPENSSL_RAW_DATA, $iv);
        $encrypted_base64 = base64_encode($encrypted);
        return $encrypted_base64;

    }
    
    public function aes128cbcDycrypt($secret_key,$string){
        $method = "AES-128-CBC";
        $encrypted_data = base64_decode($string);
        // $iv_length = opensssl_cipher_iv_length($method);
        $iv = '0102030405060708';
        $iv_length = strlen($iv);
        // $iv = substr($encrypted_data, 0, $iv_length);
        // $encrypted_data = substr($encrypted_data, $iv_length);
        $decrypted = openssl_decrypt($encrypted_data, $method, $secret_key, OPENSSL_RAW_DATA, $iv);
        // dd($decrypted);
        return $decrypted;

    }

    public function md5_sign($data, $key,$unset=[]) {
        ksort($data);
        foreach ($unset as $value){
            unset($data[$value]);
        }
        $string = http_build_query($data);
        $string = urldecode($string); 
        $string = trim($string) . "&key=" . $key;
        $string = trim($string);
        return strtoupper(md5($string));
    }

    public function addBonus($bonus_uid){
        
        $bonus['bonus_uid'] = $bonus_uid;
        $bonus['amount'] = 0.00;
        $bonus['wager_amount'] = 0.00;
        $bonus['bonus_applied_date'] = now();
        $bonus['claim_status'] = 0;
        // $bonus['type'] = 0;
        
        return $bonus;

    }
}

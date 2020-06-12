<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request; 
use Illuminate\Support\Str;
use Twilio\Rest\Client;
use App\UserProfile;
use Validator;
use App\User; 
use DB;

class UserController extends Controller 
{
public $successStatus = 200;
/** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(Request $request)
    {
        
        if(filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            $credentials = [
                'email' => $request->email
            ];
        }else{
            $credentials = [
                'username' => $request->email
            ];
        }
        if(isset($request->password)){
            $credentials['password'] = $request->password;
        }else{
            $credentials['verification_code'] = $request->verification_code;
            $user = User::where($credentials)->first();
            if($user){
                Auth::loginUsingId($user->id);
                $token = auth()->user()->createToken('Web')->accessToken;
                return response()->json(['token'=>$token],200);
            }else{
                return response()->json(['message'=>'Not found!'],200);
            }
            
        }

        if (auth()->attempt($credentials)) {


            if (auth()->user()->status_id != 1){
                return response()->json(['message'=>'User can not Login'], 401);
            }
            $token = auth()->user()->createToken('Web')->accessToken;
            
            if(!auth()->user()->phone_verified_at){

                $account_sid = 'ACf17f35f8d2da099186e8e88f3772420a';
                $auth_token = 'aacbe785c984a7deba087d6b764215ef';
                // In production, these should be environment variables. E.g.:
                // $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]
        
                // A Twilio number you own with SMS capabilities
                $twilio_number = "+12242525454";
                $verification_code = rand(100000, 999999);
        
                $client = new Client($account_sid, $auth_token);
                $client->messages->create(
    
                    "+".auth()->user()->profile->phone,
                    array(
                        'from' => $twilio_number,
                        'body' => 'Verification Code:'.$verification_code,
                    )
                );
                auth()->user()->update(['verification_code'=>$verification_code]);
                return response()->json(['token' => $token,'message'=> 'verification SMS sent','phone'=> "+".auth()->user()->profile->phone], 200);
            }

            return response()->json(['token' => $token,'user'=> Auth::user(),'message'=>'success'], 200);
        } else {
            return response()->json(['error' => 'Login Credentials where wrong '], 401);
        }
    }
/** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'username' => 'required|unique:users', 
            'password' => 'required', 
            'phone' => 'required|unique:user_profiles', 
            'country' => 'required', 
            'country_code' => 'required', 
            'address' => 'required',
        ]);
        if ($validator->fails()) { 
                    return response()->json(['error'=>$validator->errors()], 401);            
        }

        /* Get credentials from .env */

        $account_sid = 'ACf17f35f8d2da099186e8e88f3772420a';
        $auth_token = 'aacbe785c984a7deba087d6b764215ef';
        // In production, these should be environment variables. E.g.:
        // $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]

        // A Twilio number you own with SMS capabilities
        $twilio_number = "+12242525454";
        $verification_code = rand(100000, 999999);

        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
            // Where to send a text message (your cell phone?)
            "+".$request->phone,
            array(
                'from' => $twilio_number,
                'body' => 'Verification Code:'.$verification_code,
            )
        );

        $file_path ='';
    
            if ($request['image']){
                $originalImage= $request->file('image');
                $request['picture'] = $request->file('image')->store('public/storage');
                $request['picture'] = Storage::url($request['picture']);
                $request['picture'] = asset($request['picture']);
                // $filename = $request->file('image')->hashName();
                $file_path = $request['picture'];
    
            }

        $user = new User;

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->verification_code = $verification_code;
        $user->role = 'customer';

        $user->save();

        $profile = new UserProfile([
                'user_id' => $user->id,
                'address'  => $request->address,
                'longitude'  => $request->longitude,
                'latitude'  => $request->latitude,
                'city' => $request->city,
                'country'   => $request->country,
                'country_code'   => $request->country_code,
                'phone' =>  $request->phone,
                'photo' => $file_path,
            ]);

        $profile = $user->profile()->save($profile);

        $success['token'] =  $user->createToken('mobile')->accessToken; 

        $user = [
            'id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'address' => $profile->address,
            'longitude' => $profile->longitude,
            'latitude' => $profile->latitude,
            'city' => $request->city,
            'country' => $profile->country,
            'country_code' => $profile->country_code,
            'phone' => $profile->phone,
            'role' => 'customer',
            'status_id' => '1',
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ];

        $success['user'] =  $user;
        return response()->json(['success'=>$success], $this->successStatus); 
    }

    public function logout(Request $request)
    {
        $user = Auth::user()->token();
        $user->revoke();
        return response()->json([
            'message' => 'Logout successfully'
        ],200);
    }

    public function update(Request $request){
        if(!$request->name){

            if ($request['image']){
                $originalImage= $request->file('image');
                $request['picture'] = $request->file('image')->store('public/storage');
                $request['picture'] = Storage::url($request['picture']);
                $request['picture'] = asset($request['picture']);
                // $filename = $request->file('image')->hashName();
                $file_path = $request['picture'];

                $profile = DB::table('user_profiles')
                  ->where('user_id', auth()->user()->id)
                  ->update([
                    'photo' => $file_path,
                ]);
    
                if($profile){
                    return response()->json(['success'=>'User profile updated successfully'], $this->successStatus);
                }
                else{
                    return response()->json(['success'=>'Unable to update user profile'], 401);
                }
            }
            else{
                    return response()->json(['success'=>'Atleat Image is required!'], 401);
            }
            
        }else{

            $validator = Validator::make($request->all(), [ 
                'name' => 'required', 
                'email' => 'unique:users,email,'.auth()->user()->id.',id',
                'phone' => 'required|unique:user_profiles,phone,'.auth()->user()->id.',user_id',
                'gender' => 'required',
                'address' => 'required',
                'longitude' => 'required',
                'latitude' => 'required',
                'dob' => 'required',
            ]);
            if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 401);            
            }
            

            if ($request['image']){
                $originalImage= $request->file('image');
                $request['picture'] = $request->file('image')->store('public/storage');
                $request['picture'] = Storage::url($request['picture']);
                $request['picture'] = asset($request['picture']);
                // $filename = $request->file('image')->hashName();
                $file_path = $request['picture'];
    
            }
            else{
                $user = User::where('id', auth()->user()->id)->with('profile')->first();
                $file_path = $user->profile->photo;
            }

            $user = DB::table('users')
                  ->where('id', auth()->user()->id)
                  ->update(['name' => $request->name , 'email' => $request->email]);

            if($user){

                $profile = DB::table('user_profiles')
                  ->where('user_id', auth()->user()->id)
                  ->update([
                    'phone' => $request->phone, 
                    'gender' => $request->gender,
                    'photo' => $file_path,
                    'city' => $request->city,
                    'address' => $request->address,
                    'longitude' => $request->longitude,
                    'latitude' => $request->latitude, 
                    'dob' => $request->dob, 
                ]);

                return response()->json(['success'=>'User profile updated successfully'], $this->successStatus);
            }
            else{
                return response()->json(['success'=>'Unable to update user'], 200);
            }
        }

    }

/** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        $user= User::whereId(auth()->id())->with(['service_reviews','place_reviews','total_places','total_services'])->withCount(['service_reviews','place_reviews'])->first();
        $profile = UserProfile::where('user_id', $user->id)->first();

        foreach ($user->total_places as $place) {

            $user->otherRateCount += $place->rating_count;

        }

        foreach ($user->total_services as $service) {

            $user->otherRateCount += $place->rating_count;

        }

        $user = [
            'name'      =>  $user->name,
            'username'      =>  $user->username,
            'email'     => $user->email,
            'email_verified_at'  =>  $user->email_verified_at,
            'role'      =>  $user->role,
            'status_id' =>  $user->status_id,
            'address'      =>  $user->profile->address,
            'longitude'      =>  $user->profile->longitude,
            'latitude'      =>  $user->profile->latitude,
            'city'      =>  $user->profile->city,
            'country'      =>  $user->profile->country,
            'country_code'      =>  $user->profile->country_code,
            'photo'      =>  $user->profile->photo,
            'phone'      =>  $user->profile->phone,
            'gender'      =>  $user->profile->gender,
            'dob'      =>  $user->profile->dob,
            'otherRateCount' => $user->otherRateCount,
            'myReviewsCount' => $user->myReviewsCount,
            'created_at'      =>  $user->created_at,
            'updated_at'      =>  $user->profile->updated_at,
            'deleted_at'      =>  $user->deleted_at,
        ];

        return response()->json(['user' => $user], $this-> successStatus); 
    } 

    public function places(Request $request){

        $total_places = User::with('total_places')->withCount(['total_places','approved_places','disapproved_places'])->where('id', auth()->user()->id )->first();

        if($total_places){
            return response($total_places, 200);
        }
        else{
            return response(['message' => 'No Places Found!'], 200);
        }

    }

    public function services(Request $request){

        $total_services = User::with('total_services')->withCount(['total_services','approved_services','disapproved_services'])->where('id', auth()->user()->id )->first();

        if($total_services){
            return response($total_services, 200);
        }
        else{
            return response(['message' => 'No Services Found!'], 200);
        }

    }

    public function phone_verify($code){

        $user = User::whereId(auth()->id())->where('verification_code',$code)->first();

        if(!empty($user)){
            auth()->user()->update(['phone_verified_at' => date("Y-m-d H:i:s"),'verification_code'=>'']);

            return response(['user' => $user,'message' => 'success'], 200);
        }
        else{
            return response(['user' => $user,'message' => 'Invalid Code!'], 200);
        }
    }

    public function resend(){

        $user = User::select('id','verification_code')->with('profile')->where('id', auth()->user()->id)->where('verification_code', '<>', Null)->first();

        if(!empty($user)){

             /* Get credentials from .env */

            $account_sid = 'ACf17f35f8d2da099186e8e88f3772420a';
            $auth_token = 'aacbe785c984a7deba087d6b764215ef';
            // In production, these should be environment variables. E.g.:
            // $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]

            // A Twilio number you own with SMS capabilities
            $twilio_number = "+12242525454";
            $verification_code = $user->verification_code;

            $client = new Client($account_sid, $auth_token);
            $client->messages->create(
                // Where to send a text message (your cell phone?)
                $user->profile->phone,
                array(
                    'from' => $twilio_number,
                    'body' => 'Verification Code:'.$verification_code,
                )
            );

            return response(['user' => $user,'message' => 'code sent'], 200);
        }
        else{
            return response(['message' => 'Not Authorized!'], 200);
        }
    }
    
    public function send_reset_password(Request $request){
        if(filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            $user = User::where('email',$request->email)->first();
        }else{
            $user = User::where('username',$request->email)->first();
        }
        $account_sid = 'ACf17f35f8d2da099186e8e88f3772420a';
        $auth_token = 'aacbe785c984a7deba087d6b764215ef';
                // In production, these should be environment variables. E.g.:
                // $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]
        
                // A Twilio number you own with SMS capabilities
        $twilio_number = "+12242525454";
        $verification_code = rand(100000, 999999);
        
        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
            "+".$user->profile->phone,
            array(
                'from' => $twilio_number,
                'body' => 'Verification Code:'.$verification_code,
            )
        );
        $user->update(['verification_code'=>$verification_code,'phone_verified_at'=>null]);
        return response()->json(['message'=>'Code Successfully sent'],200);
    }
    
    public function restpass(Request $request){
        auth()->user()->update(['password'=>Hash::make($request->password)]);
        return response()->json(['message'=>'success'],200);
    }

}
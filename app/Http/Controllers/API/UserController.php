<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\Request; 
use Illuminate\Support\Str;
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
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($credentials)) {


            if (auth()->user()->status_id != 1){
                return response()->json(['message'=>'User can not Login'], 401);
            }
            $token = auth()->user()->createToken('Web')->accessToken;

            return response()->json(['token' => $token,'user'=> Auth::user()], 200);
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
            'email' => 'required|email:rfc|unique:users', 
            'password' => 'required', 
            'phone' => 'required|unique:user_profiles', 
        ]);
        if ($validator->fails()) { 
                    return response()->json(['error'=>$validator->errors()], 401);            
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role'=>'customer',
        ]);

        $profile = new UserProfile([
                'user_id' => $user->id,
                // 'address'  => $request->address,
                // 'city'  => $request->city,
                // 'country'   => $request->country,
                'phone' =>  $request->phone,
                // 'photo' => $request->photo,
            ]);

        $profile = $user->profile()->save($profile);

        $success['token'] =  $user->createToken('mobile')->accessToken; 

        $user = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
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
        
         $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'phone' => 'required|unique:user_profiles,phone,'.auth()->user()->id.',user_id',
            'gender' => 'required',
            'image' => 'required',
            'address' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
            'dob' => 'required',
        ]);
        if ($validator->fails()) { 
                    return response()->json(['error'=>$validator->errors()], 401);            
        }

        $user = DB::table('users')
              ->where('id', auth()->user()->id)
              ->update(['name' => $request->name]);

        $profile = DB::table('user_profiles')
              ->where('user_id', auth()->user()->id)
              ->update([
                'phone' => $request->phone, 
                'gender' => $request->gender,
                'photo' => $request->image,
                'address' => $request->address,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude, 
                'dob' => $request->dob, 
            ]);

        if($profile){
            return response()->json(['success'=>'User profile updated successfully'], $this->successStatus);
        }
        else{
            return response()->json(['success'=>'Unable to update user profile'], 401);
        }

    }

/** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        $user= Auth::user();
        $profile = UserProfile::where('user_id', auth()->user()->id)->first();

        $user = [
            'name'      =>  $user->name,
            'email'     => $user->email,
            'email_verified_at'  =>  $user->email_verified_at,
            'role'      =>  $user->role,
            'status_id' =>  $user->status_id,
            'address'      =>  $profile->address,
            'longitude'      =>  $profile->longitude,
            'latitude'      =>  $profile->latitude,
            'city'      =>  $profile->city,
            'country'      =>  $profile->country,
            'photo'      =>  $profile->photo,
            'phone'      =>  $profile->phone,
            'gender'      =>  $profile->gender,
            'dob'      =>  $profile->dob,
            'created_at'      =>  $user->created_at,
            'updated_at'      =>  $profile->updated_at,
            'deleted_at'      =>  $user->deleted_at,
        ];
        return response()->json(['user' => $user], $this-> successStatus); 
    } 


    public function total_places(Request $request){

        $total_places = User::with('total_places')->where('id', auth()->user()->id )->get();

        if($total_places){
            return response(['message' => $total_places], 200);
        }
        else{
            return response(['message' => 'No Places Found!'], 200);
        }

    }

    public function disapproved_places(Request $request){

        $disapproved_places = User::with('disapproved_places')->where('id', auth()->user()->id )->get();

        if($disapproved_places){
            return response(['message' => $disapproved_places], 200);
        }
        else{
            return response(['message' => 'No Places Found!'], 200);
        }

    }

    public function approved_places(Request $request){

        $approved_places = User::with('approved_places')->where('id', auth()->user()->id )->get();

        if($approved_places){
            return response(['message' => $approved_places], 200);
        }
        else{
            return response(['message' => 'No Places Found!'], 200);
        }

    }
}
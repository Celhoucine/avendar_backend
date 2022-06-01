<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function Clientregister(Request $request){
        $registeInfo=$request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone'=>'required'
        ]);
        $userexiste=User::where('email',$request->email)->first();
        if($userexiste)
        {
            return response('the email already exsist',403);
        }
        $create = User::create(
            [
                'fname' => $registeInfo['firstName'],
                'lname' => $registeInfo['lastName'],
                'email' => $registeInfo['email'],
                'password' => bcrypt($registeInfo['password']),


            ]
        );
        $storeclient=Client::create(
            [
                'users_id' => $registeInfo['email'],
                'phone'=>$registeInfo['phone'],
            ]
        );
        $token=$create->createToken($request->email)->plainTextToken;
        $response=[
            'token'=>$token,

        ];
        return $response;

    }
    public function Agenceregister(Request $request ){
        $registeInfo=$request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'agenceName'=> 'required|string|max:255',
            'phone'=>'required',
            'address'=>'required',
        ]);
        $userexiste=User::where('email',$request->email)->first();
        if($userexiste)
        {
            return response('the email already exsist',403);
        }
        $create = User::create(
            [
                'fname' => $registeInfo['firstName'],
                'lname' => $registeInfo['lastName'],
                'email' => $registeInfo['email'],
                'password' => bcrypt($registeInfo['password'])
            ]
        );
        $storeagenc= Agence::create(
            [
                'email'=>$registeInfo['email'],
                'phone'=>$registeInfo['phone'],
                'agenceName'=>$registeInfo['agenceName'],
                'address'=>$registeInfo['address'],
            ]
        );
        $token=$create->createToken($request->email)->plainTextToken;
        $response=[
            'token'=>$token,

        ];
        return $response;

    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            // 'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

//        return $user->createToken($request->email)->plainTextToken;
        $token=$user->createToken($request->email)->plainTextToken;
        $client =Client::where('users_id', $request->email)->first();
        if($client){
            $response=[
                'token'=>$token,
                'mode'=>'client'
            ];
            return $response;
        }
        else{
            $response=[
                'token'=>$token,
                'mode'=>'agence'
            ];
            return $response;
        }
    }
    public function  logout(){
        auth()->user()->tokens()->delete();
    }
    public function agenceverification(Request $request){
        $data=$request->user()->email;
        $response=Agence::select('verified')->where('email','=',$data)->get();
        return $response;
    }

}

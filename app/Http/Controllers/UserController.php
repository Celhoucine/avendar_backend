<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function  agenceinfo(Request $request){
        $data=$request->user()->email;
        return  User::join('agences','users.email',"=",'agences.email')
            ->select('users.id','agences.email','fname','lname','phone','address','agenceName','profile_image')
            ->where('users.email','=',$data)
            ->get();
    }
    public function  updateagenceinfo(Request $request,$email){

       $user = User::where('email','=',$email)->first();
        if($request->hasFile('imageFile')){
            $id=$user->id;
            $filepath='Public/images/'.$id.'.png';
            Storage::delete($filepath);
            $user->profile_image=$id.'.png';
            $request->file('imageFile')->storeAs('Public/images',$id.'.png');
        }
         $user->fname=$request->fname;
        $user->lname=$request->lname;
         $user->save();
        $agence = Agence::where('email','=',$email)->first();
        $agence->address=$request->address;
        $agence->phone=$request->phone;
        $agence->agenceName=$request->agenceName;
        $agence->save();




    }
    public function  clientinfo(Request $request){
        $data=$request->user()->email;
        return  User::join('clients','users.email',"=",'clients.users_id')
            ->select('users.id','email','fname','lname','phone','profile_image')
            ->where('users.email','=',$data)
            ->get();
    }
    public function  updateclientinfo(Request $request,$email){
        $user = User::where('email','=',$email)->first();
        if($request->hasFile('imageFile')){
            $id=$user->id;
            $filepath='Public/images/'.$id.'.png';
            Storage::delete($filepath);
            $user->profile_image=$id.'.png';
            $request->file('imageFile')->storeAs('Public/images',$id.'.png');
        }

        $user->fname=$request->fname;
        $user->lname=$request->lname;
        $user->save();
        $client = Client::where('users_id','=',$email)->first();
        $client->phone=$request->phone;
        $client->save();




    }
    public function updatepassword(Request $request){
        $user_password= $request->user();
        $request->validate([
            'old_password'  =>'required',
            'new_password' =>'required',
        ]);


         if(Hash::check($request->old_password,$user_password->password)){
          $user_password->update([
              'password'=>bcrypt($request->new_password)
          ]);
          return 'Password successfuly update';
         }else{
             return response('Old password is incorrect',422);
         }

    }
}

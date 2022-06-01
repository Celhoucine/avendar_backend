<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Offer;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use DB;


class FavoriteController extends Controller
{
    public  function  addfavorite(Request $request,$id)
    {
        $data = $request->user()->email;
       $count= Favorite::where('offers_id',$id)->where('clients_id',$data)->count();
        if($count==0)
       return Favorite::create([
            'offers_id'=>$id,
            'clients_id'=>$data,
        ]);
        else{
            return Favorite::where('offers_id',$id)->delete();
        }
    }

    public  function  existefavorite(Request $request,$id){
        $data = $request->user()->email;
        return   Favorite::where('offers_id',$id)->where('clients_id',$data)->count();

    }
    public function listfavorite(Request $request){
        $data = $request->user()->email;
        return  Offer::select('offers.id','description','surface','prix','name','offers.created_at',DB::raw('count(path) as images'),'email','phone','agenceName','baladiya','willaya','longitude','latitude','bathroom','garage', 'bedroom', 'livingroom', 'kitchen')
            ->join('categories','offers.categories_id','=','categories.id')
            ->join('images','offers.id','=','offer_id')
            ->join('agences','agences_id','=','email')
            ->join('favorites','offers.id','=','offers_id')
            ->where('clients_id',$data)
            ->groupBy('offers.id')
            ->get();


    }

}

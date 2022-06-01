<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public  function search(Request $request){
        $query=Offer::query();
        if($prix_max=$request->input('prix_max')){
            $query=$query->where('prix','<=',$prix_max);
        }
        if($prix_min=$request->input('prix_min')){
            $query=$query->where('prix','>=',$prix_min);
        }
        if($surface_max=$request->input('surface_max')){
            $query=$query->where('surface','<=',$surface_max);
        }
        if($surface_min=$request->input('surface_min')){
            $query=$query->where('surface','>=',$surface_min);
        }
        if($categore=$request->input('categore')){
            $query=$query->where('categories_id','=',$categore);
        }
        if($wilaya=$request->input('wilaya')){
            $query=$query->where('willaya','LIKE', '%'.$wilaya.'%');
        }




        return $query->select('offers.id','description','surface','prix','name','offers.created_at',DB::raw('count(path) as images'),'agenceName','phone','agences.email','baladiya','willaya','longitude','latitude','bathroom','garage', 'bedroom', 'livingroom', 'kitchen')
            ->join('categories','offers.categories_id','=','categories.id')
            ->join('images','offers.id','=','offer_id')
            ->join('agences','agences_id','=','email')
            ->groupBy('offers.id')
            ->get();







    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Commentaire;
use App\Models\Favorite;
use App\Models\Image;
use App\Models\Offer;
use App\Models\User;
use App\Models\Vue;
use Faker\Core\File;
use Illuminate\Http\Request;
use DB;
use Auth;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Nette\Utils\Helpers;
use phpDocumentor\Reflection\Types\True_;

class OfferController extends Controller
{
    public function addoffer (Request $request)
    {
        $data=$request->user()->email;
        $request->validate([
            'description'=>'required',
            'surface'=>'required',
            'prix'=>'required',
            'categorie'=>'required',
            'imageFile'=>'required',
            'latitude'=>'required',
            'longitude'=>'required',
            'willaya'=>'required',
            'baladiya'=>'required',
        ]);
      $offer = Offer::create([
            'description'=>$request['description'],
            'surface'=>$request['surface'],
            'prix'=>$request['prix'],
            'categories_id'=>$request['categorie'],
            'agences_id'=>$data,
          'latitude'=>$request['latitude'],
          'longitude'=>$request['longitude'],
          'willaya'=>$request['willaya'],
          'baladiya'=>$request['baladiya'],
          'bathroom'=>$request['bathroom'],
          'garage'=> $request['garage'],
          'bedroom'=> $request['bedroom'],
          'livingroom' =>$request['livingroom'],
          'kitchen'=>$request['kitchen'],

        ]);
        $offerid=$offer->id;
        if($request->hasFile('imageFile')){
            $i=0;
            foreach($request->file('imageFile') as $file){
                $name= $file->getClientOriginalName();
                $file->storeAs('Public/images',$offerid.'_'.$i.'.png');

                Image::create([
                    'offer_id'=>$offerid,
                    'path'=>$offerid.$i.'png'
                ]);
                $i=$i+1;
            }

        }


    }

    public  function  getoffer(){
        return Offer::select('offers.id','description','surface','prix','name','offers.created_at',DB::raw('count(path) as images'),'agenceName','phone','agences.email','baladiya','willaya','longitude','latitude','bathroom','garage', 'bedroom', 'livingroom', 'kitchen')
            ->join('categories','offers.categories_id','=','categories.id')
            ->join('images','offers.id','=','offer_id')
            ->join('agences','agences_id','=','email')
            ->groupBy('offers.id')
            ->get();

    }
//    public  function  getDetailoffer($id){
//        $resp1= Offer::join('categories','offers.categories_id','=','categories.id')
//            ->join('agences','offers.agences_id','=','email')
//            ->select('offers.id','description','surface','prix','name','offers.created_at','email','agenceName')
//            ->where('offers.id','=',$id)
//            ->get();
//
//        return $response=[
//            'detail'=>$resp1,
//
//        ];
//    }

    public  function  Highprice(){
        return Offer::select('offers.id','description','surface','prix','name','offers.created_at',DB::raw('count(path) as images'),'agenceName','phone','agences.email','longitude','latitude','baladiya','willaya','longitude','latitude','bathroom','garage', 'bedroom', 'livingroom', 'kitchen')
            ->join('categories','offers.categories_id','=','categories.id')
            ->join('images','offers.id','=','offer_id')
            ->join('agences','agences_id','=','email')
            ->groupBy('offers.id')
            ->orderBy('prix', 'desc')
            ->get();
    }
    public  function  Lowprice(){
        return Offer::select('offers.id','description','surface','prix','name','offers.created_at',DB::raw('count(path) as images'),'agenceName','phone','agences.email','longitude','latitude','baladiya','willaya','longitude','latitude','bathroom','garage', 'bedroom', 'livingroom', 'kitchen')
            ->join('categories','offers.categories_id','=','categories.id')
            ->join('images','offers.id','=','offer_id')
            ->join('agences','agences_id','=','email')
            ->groupBy('offers.id')
            ->orderBy('prix', 'asc')
            ->get();
    }
    public  function  Highsurface(){
        return Offer::select('offers.id','description','surface','prix','name','offers.created_at',DB::raw('count(path) as images'),'agenceName','phone','agences.email','longitude','latitude','baladiya','willaya','longitude','latitude','bathroom','garage', 'bedroom', 'livingroom', 'kitchen')
            ->join('categories','offers.categories_id','=','categories.id')
            ->join('images','offers.id','=','offer_id')
            ->join('agences','agences_id','=','email')
            ->groupBy('offers.id')
            ->orderBy('surface', 'desc')
            ->get();
    }
    public  function  Lowsurface(){
        return Offer::select('offers.id','description','surface','prix','name','offers.created_at',DB::raw('count(path) as images'),'agenceName','phone','agences.email','longitude','latitude','baladiya','willaya','longitude','latitude','bathroom','garage', 'bedroom', 'livingroom', 'kitchen')
            ->join('categories','offers.categories_id','=','categories.id')
            ->join('images','offers.id','=','offer_id')
            ->join('agences','agences_id','=','email')
            ->groupBy('offers.id')
            ->orderBy('surface', 'asc')
            ->get();
    }
    public  function  Oldoffer(){
        return Offer::select('offers.id','description','surface','prix','name','offers.created_at',DB::raw('count(path) as images'),'agenceName','phone','agences.email','longitude','latitude','baladiya','willaya','longitude','latitude','bathroom','garage', 'bedroom', 'livingroom', 'kitchen')
            ->join('categories','offers.categories_id','=','categories.id')
            ->join('images','offers.id','=','offer_id')
            ->join('agences','agences_id','=','email')
            ->groupBy('offers.id')
            ->orderBy('created_at', 'asc')
            ->get();
    }
    public  function  Newoffer(){
        return Offer::select('offers.id','description','surface','prix','name','offers.created_at',DB::raw('count(path) as images'),'agenceName','phone','agences.email','longitude','latitude','baladiya','willaya','longitude','latitude','bathroom','garage', 'bedroom', 'livingroom', 'kitchen')
            ->join('categories','offers.categories_id','=','categories.id')
            ->join('images','offers.id','=','offer_id')
            ->join('agences','agences_id','=','email')
            ->groupBy('offers.id')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    public  function  getagenceoffer(Request $request){
        $data=$request->user()->email;
         return Offer::select('offers.id','description','surface','prix','name','offers.created_at',DB::raw('count(path) as images'),'agenceName','phone','agences.email','baladiya','willaya','longitude','latitude','bathroom','garage', 'bedroom', 'livingroom', 'kitchen')
         ->join('categories','offers.categories_id','=','categories.id')
             ->join('agences','agences_id','=','email')
             ->join('images','offers.id','=','offer_id')
             ->where('agences_id','=',$data)
             ->groupBy('offers.id')
             ->get();

    }
    public  function  getCategories(){
        return Category::all();
    }
    public  function addcomment(Request $request){
        $data=$request->user()->email;
        $request->validate([
            'offers_id'=>'required',
            'text'=>'required'

        ]);
        $addcomment = Commentaire::create([
            'users_id'=>$data,
            'offers_id'=>$request['offers_id'],
            'text'=>$request['text']
        ]);
    }
    public function  getcomments($id){
        return Commentaire::select('users.id','offers_id','text','fname','lname','commentaires.created_at','profile_image')
            ->join('users','commentaires.users_id','=','users.email')
              ->orderBy('created_at', 'asc')
                ->where('offers_id','=',$id)

                ->get();
    }
    public function deleteoffer(Request $request,$id){
       $image=Image::where('offer_id','=',$id)->count();

            for ($i=0;$i<$image;$i++){
              $filepath='Public/images/'.$id.'_'.$i.'.png';
                Storage::delete($filepath);
        }
           Image::where('offer_id','=',$id)->delete();
           Vue::where('offers_id','=',$id)->delete();
           Commentaire::where('offers_id','=',$id)->delete();
           Favorite::where('offers_id','=',$id)->delete();
           Offer::where('id','=',$id)->delete();
    }
    public function  editoffer(Request $request,$id){
      if($request->withimage=='true'){
          $image=Image::where('offer_id','=',$id)->count();
          for ($i=0;$i<$image;$i++){
              $filepath='Public/images/'.$id.'_'.$i.'.png';
              Storage::delete($filepath);
          }
          Image::where('offer_id','=',$id)->delete();
          if($request->hasFile('imageFile')){
              $i=0;
              foreach($request->file('imageFile') as $file){
                  $name= $file->getClientOriginalName();
                  $file->storeAs('Public/images',$id.'_'.$i.'.png');

                  Image::create([
                      'offer_id'=>$id,
                      'path'=>$id.$i.'png'
                  ]);
                  $i=$i+1;
              }
          }

      }
       $offer=Offer::where('id','=',$id)->first();
       $offer->description=$request->description;
       $offer->surface=$request->surface;
       $offer->prix=$request->prix;
       $offer->categories_id=$request->categorie;
       $offer->longitude=$request->longitude;
       $offer->latitude=$request->latitude;
       $offer->baladiya=$request->baladiya;
       $offer->willaya=$request->willaya;
       $offer->bathroom=$request->bathroom;
       $offer->garage=$request->garage;
       $offer->bedroom=$request->bedroom;
       $offer->livingroom=$request->livingroom;
       $offer->kitchen=$request->kitchen;
$offer->save();
return $request;

    }

   public  function addvue(Request $request,$id){
     $data=$request->user()->email;
         $vuexsiste=Vue::where('clients_id','=',$data)->where('offers_id','=',$id)->first();
     if(!$vuexsiste ){
           Vue::create([
             'clients_id'=>$data,
               'offers_id'=>$id,
           ]);
         return true;
       }
   }
   public function getvues(Request $request,$id){
        $vues=Vue::
            where('offers_id','=',$id)->count();
        return $vues;
   }



}

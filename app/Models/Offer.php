<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Offer extends Model
{

    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable=[
        'agences_id',
        'id',
        'description',
        'surface',
        'prix',
        'categories_id',
        'longitude',
        'latitude',
        'baladiya',
        'willaya',
        'bathroom',
        'garage',
        'bedroom',
        'livingroom',
        'kitchen',


    ];
    public function agence(){
        return $this->belongsTo(Agence::class,'agences_id','email');
    }
    public  function images(){
        return $this->hasMany(Image::class);
    }

}

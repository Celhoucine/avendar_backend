<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Image extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable=[
        'offer_id',
        'id',
        'path',

    ];
    public function offer(){
        return $this->belongsTo(Offer::class);
    }
}

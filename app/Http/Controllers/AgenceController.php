<?php

namespace App\Http\Controllers;

use Dotenv\Validator;
use Illuminate\Http\Request;
use App\Models\Agence;
class AgenceController extends Controller
{
    public function  show(){

        return Agence::all();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class listcontroller extends Controller
{
    public function view(){
        return view('firebase.userslist');
    }
}

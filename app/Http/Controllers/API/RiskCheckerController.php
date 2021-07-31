<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class RiskCheckerController extends Controller
{
    //check risk when user login to core banking system
    public function checkRisk(Request $request){
        $email = $request->validate(['email'=>'required|email']);

        $check_user = User::where('email',$email)->first();

        //if user not found in system
        if($check_user === null){
            return response()->json(['unregistered user with following email trying to login the system'=>$email],401);
        }

        //check for subnet, mac_address, working_hrs
        if(($check_user->subnet == '255.255.255.0') && ($check_user->mac_address  ==111) && ($check_user->working_hrs == '2:00 AM')){
            return response()->json(['All matched','user'=>$check_user], 200);
        }else{
            return response()->json(['risk exeption'=> 'Not matching with security measures ***'], 401);
        }
       
    }
}

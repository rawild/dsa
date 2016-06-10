<?php

namespace dsa\Http\Controllers;

use dsa\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class UserController extends Controller {


    public function __construct() {
        # Put anything here that should happen before any of the other actions
    }

    public function getAdd(Request $request){


      return view('user.add')->with('message', "");
    }
    public function postAdd(Request $request){
      $users = \dsa\User::where('email','=',$request->email)->get();
      if(sizeof($users) > 0) {
        return view('user.add')->with('message', "User already exists");
      } else {
        $user = new \dsa\User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = \Hash::make($request->password);
        $user->role = $request->role;
        $user->save();
        return view('user.add')->with('message',"User Added");
      }

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
   public function testMethod (){
       return response()->json([
           'msg' => 'we should return only json'
       ]);
   }

    public function testing() {
       return response()->json([
           'msg' => "somme error"
       ]);
   }
}

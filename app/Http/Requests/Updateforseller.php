<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class Updateforseller {
   public static function validate($request){
    $request->validate([
        'name'=>'required|string',

        "description"=>	"required",
        "small_descripe"=>'required',
        'parent_id'=>'required|numeric',
        'price'=>'required|numeric',
        'special_name'=>'required|string',
        "type"=>"required",
        'category_id'=>'required|numeric',
        'sale'=>'nullable|numeric',
         'details'=>'nullable|string',
    ]);
   }
}

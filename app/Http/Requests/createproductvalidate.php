<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class createproductvalidate {

   public static function validate($request){
    if($request->type=="category"){
    $request->validate([
        'name'=>'required|string',
        "photo"	=>'required|image',
        "description"=>	"required",
        "small_descripe"=>'required',
        'parent_id'=>'nullable|numeric',
        'price'=>'nullable|numeric',
        'special_name'=>'required|string',
        "type"=>"required",
        'sale'=>'nullable|numeric',

    ]);}
    elseif($request->type=="sub category"){
        $request->validate([
            'name'=>'required|string',
            "photo"	=>'required|image',
            "description"=>	"required",
            "small_descripe"=>'required',
            'parent_id'=>'nullable|numeric',
            'price'=>'nullable|numeric',
            'special_name'=>'required|string',
            "type"=>"required",
            'category_id'=>'required|numeric',
            'sale'=>'nullable|numeric',

        ]);
   }else{
    $request->validate([
        'name'=>'required|string',
        "photo"	=>'required|image',
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
}

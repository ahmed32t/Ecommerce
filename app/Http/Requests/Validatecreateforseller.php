<?php
namespace App\Http\Requests;
class Validatecreateforseller{
    public static function validate($request){
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

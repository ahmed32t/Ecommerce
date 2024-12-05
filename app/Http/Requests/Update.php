<?php

namespace App\Http\Requests;



class update
{  //in view we make each input have the last value that he had before these  current updates
    //by value= "{{$item->    }}""
    public static function update_validate($request){
        if($request->type=="category"){
            $request->validate([
                'name'=>'required|string',

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

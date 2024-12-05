<?php
namespace App\service;
use App\utils\Imageuploade;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\parrentcategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\NewCategory;

  class shownewelementadded{
    public function index($request){
        // send all new product
  $category=Category::orderBy("created_at",'DESC')->get();
  ##get earler categoey add  [$newcategory]
  $newcategory=$category->first();
###get prevese category add to NewCategory
  $previous_category_number=NewCategory::orderBy("created_at",'DESC')->first();
  ####get current category number
  $currnt_category_number=Category::count();

if(!empty($newcategory)){
   if(!empty($previous_category_number)){

               if($currnt_category_number>$previous_category_number->numberofcategories){
                       ####the new cattegory is  added than last check
                    $catt=Category::where('created_at','>',$previous_category_number->time)->
                    orderBy("created_at",'DESC')->get();


                        foreach($catt as $item){
                        NewCategory::create(["numberofcategories"=>$currnt_category_number,
                        'newcategory'=>$item->special_name,
                        'time'=>$item->created_at,
                         'user_id'=>$item->user_id,


                        ]);
                        $currnt_category_number--; }

                        $newcategoryarray= NewCategory::
                        where('created_at','>',$previous_category_number->created_at)->orderBy("created_at",'DESC')
                       ->get();


                 return view('item.index')->with('category',$category)->
              with('newcategoryarray',$newcategoryarray)->with('messageofadding',' new element  is added');

            }
            else{
                    return view('item.index')->with('category',$category);}
    }


    else {
        $catt=Category::
        orderBy("created_at",'DESC')->get();


            foreach($catt as $item){
            NewCategory::create(["numberofcategories"=>$currnt_category_number,
            'newcategory'=>$item->special_name,
            'time'=>$item->created_at,
             'user_id'=>$item->user_id,


            ]);
            $currnt_category_number--; }


            $newcategoryarray=NewCategory::orderBy('created_at','DESC')->get();
        return view('item.index')->
        with('newcategoryarray',$newcategoryarray)
        ->
        with('messageofadding','these is all categories& product')->with('category',$category);
    }}
else{$category=Category::all();
    return view('item.index')->with('category',$category)->with('messageofadding','these is no categories');
}
}
  }

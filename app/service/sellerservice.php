<?php
namespace App\service;
use App\utils\Imageuploade;
use App\Models\parrentcategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\NewCategory;
use App\service\shownewelementadded;
 class sellerservice{



    public function store($request)
    {
        $Special_name=$request->special_name;
       $slug=Str_shuffle(Str::slug($Special_name.$request->small_descripe));
       //check if cspecial name already  exists

if(Category::where('special_name',$Special_name)->exists()){return redirect()->back()->
    with('message','these sprcial_name aleardy exist change it');}
else{   $Special_name=$request->special_name;
    $slug=Str_shuffle(Str::slug($Special_name.$request->small_descripe));

    $allrequest=$request->all();
    $allrequest['slug']=$slug;
    $allrequest['user_id']=Auth::id();
    $allrequest['photo']=Imageuploade::uploadeImage($request);
    if(!empty($request->sale)){
        $saleAmount=($request->price)*(($request->sale)/100);

          $allrequest['price']=(($request->price) - $saleAmount);
}
// if the subcategory  product belong to it has sale
//so make the sale in price

elseif(Category::where('id',$request->parent_id)->whereNotNull('sale')->exists())
{$subcategory=Category::where('id',$request->parent_id)->first();
    $saleAmount=($request->price)*(($subcategory->sale)/100);

      $allrequest['price']=(($request->price)  - $saleAmount);
      $allrequest['sale']=$subcategory->sale;
}
  // if the category  product belong to it has sale
//so make the sale in price

elseif(parrentcategory::where('id',$request->category_id)->whereNotNull('sale')->exists())
{
    $parrentcategory=parrentcategory::where('id',$request->category_id)->first();
    $saleAmount=($request->price)*(($parrentcategory->sale)/100);

       $allrequest['price']=(($request->price) - $saleAmount);
       $allrequest['sale']=$parrentcategory->sale;
}

    Category::create($allrequest);

       return redirect()->back()->
        with('message','there is new product was added');
    }

}







    /**
     * Update the specified resource in storage.
     */
    public function update($request,$slug,$category,$parrentcategory)
    {
        if(Category::where('special_name',$request->special_name)->where('slug','!=',$slug)
        ->exists())
        {return redirect()->back()->
            with('message','these sprcial_name aleardy exist change it');
        }
        elseif($request->type=="product"&&
           $category->where('slug',$slug)->where('user_id',Auth::id())->whereNotNull('parent_id')->
              exists())
        {
         $product=Category::where('slug',$slug)->first();

        $all_request_except_photo=$request->except('photo');



                //  sale of product not null and new
                if(!empty($request->sale) && $request->sale != $product->sale){
                    $all_request_except_photo['sale']=$request->sale;
                    $saleAmount=($request->price)*(($request->sale)/100);

                    $all_request_except_photo['price']=(($request->price) - $saleAmount);
                }
               else{   // first sale of product is empty
                // if change the sub cattegory of product and sale of product is empty
                        //product take the sale of these sub cattegory
                      if(empty($product->sale)
                      &&$product->parent_id != $request->parent_id &&

                        Category::where('id',$request->parent_id)->
                        whereNotNull('sale')->exists()){
                         $newsubcategory= Category::where('id',$request->parent_id)->first();
                           $saleAmount=($request->price)*(($newsubcategory->sale)/100);
                           $all_request_except_photo['sale']=$newsubcategory->sale;
                        $all_request_except_photo['price']=(($request->price) - $saleAmount);
                       }
                        // if change the cattegory of product and sale of product is empty
                        //product take the sale of these cattegory
                       elseif(empty($product->sale) &&
                        $product->category_id != $request->category_id &&
                       $parrentcategory->where('id',$request->category_id)->
                        whereNotNull('sale')->exists()){
                                $newparrentcategory= parrentcategory::where('id',$request->category_id)->first();
                               $saleAmount=($request->price)*(($newparrentcategory->sale)/100);
                               $all_request_except_photo['sale']=$newparrentcategory->sale;
                               $all_request_except_photo['price']=(($request->price) - $saleAmount);

                            }
                    }

        if(!empty($request->photo)){
                $product->update(
                    ["photo"=> Imageuploade::uploadeImage($request)]);
        }

        $product->update($all_request_except_photo);
        return redirect()->back()->with('message','these items is updated successfully');
    }




    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug,$item)
    {
        $item12=$item->where('slug',$slug)->where('user_id',Auth::id())->first();
      /*
    // we will not do these because seller donot have any access in delete or create or edit category
    if($item->parent_id==null)

        {foreach($item->product as $item){
            NewCategory::where("newcategory",$item->special_name)->delete();
            $item->delete();
        }}*/
        $item12->delete();
   return redirect()->back()->with('message','you just delete this item:');




 }
 public function restore($slug){
     $item=Category::onlyTrashed()->where('user_id',Auth::id())->where('slug',$slug)->
     whereNotNull('parent_id')->first();

     $item->restore();
     return redirect()->back()->with('message','you just restore this element');
 }
}

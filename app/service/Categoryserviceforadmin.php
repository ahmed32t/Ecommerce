<?php
namespace App\service;
use App\utils\Imageuploade;
use App\Models\Category;
use App\Models\parrentcategory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\NewCategory;
use App\service\shownewelementadded;
use App\Http\Requests\createproductvalidate;
 class Categoryserviceforadmin{
   public function __construct(shownewelementadded $index_with_show_new_element_was_added) {
    $this->elements =$index_with_show_new_element_was_added;
   }

    public function index($request){
      $parrentcategory=parrentcategory::orderBy('created_at','DESC')->get();
      $subcategory=Category::where('parent_id',null)->orderBy('created_at','DESC')->get();
      $product=Category::whereNotNull('parent_id')->orderBy('created_at','DESC')->get();
      return view('item.index')->with('parrentcategory',$parrentcategory)->
      with('subcategory',$subcategory)
      ->with('product',$product);
   }


    public function create()
    {    $parrentcategory=parrentcategory::all();
        $subcategory=Category::where('parent_id',null)->get();

        return view('item.create')->with('subcategory',$subcategory)->with('parrentcategory',
    $parrentcategory);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($request,$category)
    {
        $Special_name=$request->special_name;
       $slug=Str_shuffle(Str::slug($Special_name.$request->small_descripe));

       $allrequest=$request->all();
       $allrequest['slug']=$slug;
       $allrequest['user_id']=Auth::id();
       $allrequest['photo']=Imageuploade::uploadeImage($request);

if(Category::where('special_name',$Special_name)->exists()||
parrentcategory::where('special_name',$Special_name)->exists()){return redirect()->back()->
    with('message','these sprcial_name aleardy exist change it');}
else{  // if want to create parrent category

      if($request->type=="category"){




                parrentcategory::create($allrequest);


                        return redirect()->back()->
                        with('message','there is new category was added');
           }


     // if want to create sub category
        elseif($request->type=="sub category"){



                    Category::create($allrequest);
                      return redirect()->back()->
                    with('message','there is new sub category was added');

        }
        else{     //product




              // if the specific product has sale
              //so make the sale in price
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
}




    /**
     * Display the specified resource.
     */
    public function show($category)
    {   if( Category::withTrashed()->
            where('slug',$category)->exists()){
                   $category= Category::withTrashed()->
                   where('slug',$category)->first();
        // use in category section
          $parrentcategory=null;

        }

        else{
            $category= parrentcategory::withTrashed()->
            where('slug',$category)->first();
            // use in category section
            $parrentcategory=$category;

        }

        return view('item.show')->with('category',$category)->with('parrentcategory',$parrentcategory);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update($request,$slug,$category,$parrentcategory)

    {

/*
         $category= $category->withTrashed()->where('slug',$slug)->first();

        if(NewCategory::withTrashed()->where('newcategory',$category->special_name)->exists()){

                NewCategory::withTrashed()->where('newcategory',$category->special_name)->first()->
                       update([

                            'newcategory'=>$request->special_name,

                        ]);
        }

*/
// if the item was updated the specian name change so these to make sure it does not
// match any specian name of  any other item
    if(Category::where('special_name',$request->special_name)->where('slug','!=',$slug)
    ->exists()||$parrentcategory->where('special_name',$request->special_name)->where('slug','!=',$slug)
    ->exists())
    {return redirect()->back()->
        with('message','these sprcial_name aleardy exist change it');
    }
    elseif($request->type=="category"&&$parrentcategory->where('slug',$slug)->exists()){
       $parrentcategory= $parrentcategory->where('slug',$slug)->first();

//
//
        if(!empty($request->sale)){
                //if sale changed change the sale of product that belong to it that does not have sale

                if($request->sale!=$parrentcategory->sale&&
                    Category::whereNotNull('parent_id')->where('category_id',$parrentcategory->id)->exists())
                 {
                  $product= Category::whereNotNull('parent_id')->where('category_id',$parrentcategory->id)->get();

                    foreach($product as $item){
                        //product does not have any sale will have the sale of category
                       if($item->sale==null){
                       $item->sale=$request->sale;
                       $saleAmount=($item->price)*(($item->sale)/100);
                       $item->price= ( $item->price)-($saleAmount) ;
                       $item->save();
                       }
                    }
                }
         }
        if(!empty($request->photo)){

            $parrentcategory->update(
                ["photo"=> Imageuploade::uploadeImage($request)]);
        }
       $parrentcategory->update($request->except('photo'));

          }
    elseif($request->type=="sub category"&&
    $category->where('slug',$slug)->exists()){
            $subcategory=$category->where('slug',$slug)->first();
        //if sale changed change the sale of product that belong to it that does not have sale
                    if(!empty($request->sale)   &&

                    $subcategory->product()->exists()){
                              $product= $subcategory->product;

                        foreach($product as $item){
                            $item->update([
                                'category_id' => $request->category_id,
                            ]);
                            if($item->sale==null){

                            //$item->sale=$request->sale;
                            $saleAmount=($item->price)*(($request->sale)/100);
                            $newprice= ( $item->price)-($saleAmount) ;
                            $item->update([
                                'price' => $newprice,
                                'sale' =>$request->sale,
                            ]);
                            $item->save();
                            }
                        }
                    }
        if(!empty($request->photo)){
            $subcategory->update(
                ["photo"=> Imageuploade::uploadeImage($request)]);
        } $all_request_except_photo=$request->except('photo');

           $all_request_except_photo['parent_id']=null;// so  if it come from product
        $subcategory->update($all_request_except_photo);


    }
    elseif($request->type=="product"&&
    $category->where('slug',$slug)->exists()){
        $product=Category::where('slug',$slug)->first();
        if($product->parent_id == null){
            if($product->id ==$request->parent_id){
                return redirect()->back()->with('message','you cannot update these subcategory to be product
                and make it also belong to it self when it was subcategory :so change sub category');
            }
        }
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
    }
    //
    else {
             // the type is changed from using table   parrentcategories to subcategory_products
             //so we have to delete from parent category  and create in  subcategory_products

        if(($request->type == "product" || $request->type == "sub category")&&
        $parrentcategory->where('slug',$slug)->exists()) {

            createproductvalidate::validate($request);
            $parrentcategory=$parrentcategory->where('slug',$slug)->first();
            if($parrentcategory->id ==$request->category_id){
                return redirect()->back()->with('message','you cannot update these category to be product
                and make it also belong to it self when it was category :so change sub category');
            }
            $parrentcategory->forceDelete();
            $this->store($request,$category);

        return redirect()->route('newindex')->with('message','these items is updated successfully');
         }
          // the type is changed from using table   subcategory_products  to  parrentcategories
             //so we have to delete from   subcategory_products and create in  parent category
        elseif($request->type=="category" &&  Category::where('slug',$slug)->exists()){
            createproductvalidate::validate($request);
            $item=Category::where('slug',$slug)->first();
            //if it sub category
             if($item->parent_id == null){
                 foreach($item->product as $product){
                    $product->forceDelete();
                 }
             }
            $item->forceDelete();
           $this->store($request,$category);

            return redirect()->route('newindex')->with('message','these items is updated successfully');
        }




    }
    return redirect()->back()->with('message','these items is updated successfully');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug,$category)
    {   if($category->where('slug',$slug)->exists()){
        $item=$category->where('slug',$slug)->first();
        //NewCategory::where("newcategory",$category->special_name)->delete();
            if($item->parent_id==null) //these mean is sub category

                  {foreach($item->product as $product){
           // Newitem::where("newitem",$item->special_name)->delete();
                  $product->delete(); // delete all products that belong to this item
                 }
            }
        $item->delete();
        }else{
            $item=parrentcategory::where('slug',$slug)->first();
        //NewCategory::where("newcategory",$category->special_name)->delete();
            //these mean is category

                   foreach($item->subcategory as $subcategory){

                            foreach($subcategory->product as $product){

                             $product->delete(); // delete all products that belong to this item
                            }

                      $subcategory->delete();
                    } // delete all subcategory that belong to this item


                 $item->delete(); // delete the category
        }
   return redirect()->route('newindex')->with('message','you just delete this element:');





    }
 public function restore($slug){
    if(Category::onlyTrashed()->where('slug',$slug)->exists()){
        $subcategory=Category::onlyTrashed()->where('slug',$slug)->first();
        $subcategory->restore();

    }

    else{
        $parrentcategory=parrentcategory::onlyTrashed()->where('slug',$slug)->first();
        $parrentcategory->restore();
    }
     return redirect()->back()->with('message','you just restore this element');

}
public function restoreallproduct($slug){
    if(Category::onlyTrashed()->where('slug',$slug)->where('parent_id',null)->exists()){
        $subcategory=Category::onlyTrashed()->where('slug',$slug)->where('parent_id',null)->first();
        foreach($subcategory->product as $product){
            $product->restore();
        }
        $subcategory->restore();

    }

    elseif( parrentcategory::onlyTrashed()->where('slug', $slug)->exists()){
         $parrentcategory=parrentcategory::onlyTrashed()->where('slug', $slug)->first();

        // Restore all subcategories and their products
        foreach($parrentcategory->subcategory as $subcategory){
            foreach($subcategory->product as $product){
                $product->restore();
            }
            $subcategory->restore();

        }

        // Restore the category
        $parrentcategory->restore();
    }
    else{return redirect()->back()->with('message','these element not in trash');
    }
     return redirect()->back()->with('message','you just restore all these  elements');


}

 }

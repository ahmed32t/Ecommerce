<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\service\Categoryserviceforadmin;
use App\Http\Requests\createproductvalidate;
use App\Http\Requests\Update;
use App\Models\NewCategory;
use App\Models\parrentcategory;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(Categoryserviceforadmin $category_service_for_admin) {
        $this->categoryservice =$category_service_for_admin;
    }
    public function index( Request $request )
    {
        return  $this->categoryservice->index($request);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->categoryservice->create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( Request  $request,Category $category)
    {
        createproductvalidate::validate($request);
       return $this->categoryservice->store($request,$category);

    }

    /**
     * Display the specified resource.
     */
    public function show( $category)
    {
       return  $this->categoryservice->show($category);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($category)


    {    $parrentcategory=parrentcategory::withTrashed()->get();
        $subcategory=Category::withTrashed()->where('parent_id',null)->get();
        // check if it sub category or product
        if( Category::withTrashed()->where('slug',$category)->exists()){
            if(Category::withTrashed()->where('slug',$category)->where('parent_id',null)->exists()){
                     $type="sub category";
                    $item=Category::withTrashed()->where('slug',$category)->first();
            }
            else{    $type='product';
                    $item=Category::withTrashed()->where('slug',$category)->first();
            }

        } //if not sub category or product  then it will parrentcategory
        else{
             $item=parrentcategory::withTrashed()->where('slug',$category)->first();
             $type="category";
        }
      // $item for give each coulm it value  in front end so make it easser
      // in write in[use update($request->all))]
       // update method because will each input has it value so you will change it only what you want

        return view('item.edit')->with('slug',$category)->with('parrentcategory',$parrentcategory)
        ->with('subcategory',$subcategory)->with('item1',$item)->with('type',$type);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$slug, Category $category,parrentcategory $parrentcategory)
    {

        Update::update_validate($request);
        return $this->categoryservice->update($request,$slug,$category,$parrentcategory);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug,Category $category)
    {
        return $this->categoryservice->destroy($slug,$category);
    }
    public function trash(){

        $parrentcategory=parrentcategory::onlyTrashed()->orderBy('created_at','DESC')->get();
        $subcategory = Category::onlyTrashed()->where('parent_id',null)->
        orderBy('created_at','DESC')->get();
        $product=Category::onlyTrashed()->whereNotNull('parent_id')->orderBy('created_at','DESC')->get();

        return view('item.trash')->
        with('subcategory',$subcategory)->with('parrentcategory',$parrentcategory)->
        with('product',$product);
    }
    public function restore($slug){

        return $this->categoryservice->restore($slug);

    }

public function permanentDelete($slug){
    if(Category::onlyTrashed()->where('Slug',$slug)->exists()){
           $item=  Category::onlyTrashed()->where('Slug',$slug)->first();



               if($item->parent_id ==null){

                    foreach  ( $item->product as $product){

                     $product->forceDelete();
                    }
                }

     $item->forceDelete();
   }
   else{
        $item=  parrentcategory::onlyTrashed()->where('Slug',$slug)->first();
        foreach($item->subcategory as $subcategory){
            foreach($subcategory->product as $product){
                $product->forceDelete();
            }
            $subcategory->forceDelete();

        }
       $item->forceDelete();
   }
return redirect()->back()->with('message','you just deleted it for ever');
}

  public function restoreallproduct($slug){
    return $this->categoryservice->restoreallproduct($slug);
  }

}

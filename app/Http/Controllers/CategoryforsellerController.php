<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\parrentcategory;
use App\service\sellerservice;

use App\Http\Requests\Validatecreateforseller;
use App\Http\Requests\Updateforseller;
use App\Models\NewCategory;
use Illuminate\Support\Facades\Auth;
class CategoryforsellerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(sellerservice $service_for_seller) {
        $this->itemservice =$service_for_seller;
    }
    public function index()
    {  $parrentcategory=parrentcategory::orderBy('created_at','DESC')->get();
        $subcategory=Category::where('parent_id',null)->orderBy('created_at','DESC')->get();
       $product= Category::where('user_id',Auth::id())->whereNotNull('parent_id')->
       orderBy("created_at",'DESC')->get();

        return view('itemforseller.index')->with('product',$product)
        ->with('subcategory',$subcategory)->with('parrentcategory',$parrentcategory);
    }


    public function create()
    {  $parrentcategory=parrentcategory::orderBy('created_at','DESC')->get();
        $subcategory=Category::where('parent_id',null)->orderBy('created_at','DESC')->get();

      return view('itemforseller.create')->with('subcategory',$subcategory)->
      with('parrentcategory',$parrentcategory);


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( Request  $request)
    {
        Validatecreateforseller::validate($request);
       return $this->itemservice->store($request);

    }

    /**
     * Display the specified resource.
     */
    public function show( $seller)
    {
      $item=category::withTrashed()->
      where('slug', $seller)->where('user_id',Auth::id())->whereNotNull('parent_id')->first();
      return view('itemforseller.show')->with('item',$item);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($seller)

    {

        $item=Category::withTrashed()->
        where('slug',$seller)->where('user_id',Auth::id())->firstOrFail();

        $subcategory=Category::where('parent_id',null)->get();
        $parrentcategory=parrentcategory::orderBy('created_at','DESC')->get();
        return view('itemforseller.edit')->with('slug',$seller)->with('subcategory',$subcategory)
        ->with('item',$item)->
        with('parrentcategory',$parrentcategory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug,Category $category,parrentcategory $parrentcategory)

    {
        Updateforseller::validate($request);

        return $this->itemservice->update($request,$slug,$category,$parrentcategory);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug,Category $item)
    {
        return $this->itemservice->destroy($slug,$item);
    }
    public function trash(){
        $item = Category::onlyTrashed()->where('user_id',Auth::id())->whereNotNull('parent_id')->get();


        return view('itemforseller.trash')->with('item',$item);
    }
    public function restore($slug){

        return $this->itemservice->restore($slug);

    }
    public function permanentDelete($slug){
      $item=  Category::onlyTrashed()->where('user_id',Auth::id())->where('Slug',$slug)->
      whereNotNull('parent_id')->first();



   $item->forceDelete();
  return redirect()->back()->with('message','you just deleted it for ever');

    }
}

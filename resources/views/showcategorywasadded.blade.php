{{--
    public function index($request){
        // send all new product
  $category=Category::orderBy("created_at",'DESC')->get();
  ##get earler categoey add  [$newcategory]
  $newcategory=$category->first();
###get prevese category add to Numberofcategory
  $previous_category_number=Numberofcategory::orderBy("created_at",'DESC')->first();
  ####get current category number
  $currnt_category_number=Category::count();

if(!empty($newcategory)){
   if(!empty($previous_category_number)){
  // if previous_category_number not exist it will sit it with value=0
         //$previous_category_number= $request->session()->get('previous_category_number',0);

               if($currnt_category_number>$previous_category_number->numberofcategories){
                       ####the new cattegory is  added than last check
                    $catt=Category::where('created_at','>',$previous_category_number->time)->
                    orderBy("created_at",'DESC')->get();
 ##you must do  orderBy("created_at",'DESC') because must the newst category be the newst and first in  Numberofcategory
 ##because of we will compare these fisrt  to get the new category added after him
############takecare foreach will follow these order orderBy("created_at",'DESC')
###that is mean the first and newest in categores table will be the first and newst in Numberofcategory
### and   the last in categores table will be the last in Numberofcategory

                        foreach($catt as $item){
                        Numberofcategory::create(["numberofcategories"=>$currnt_category_number,
                        'newcategory'=>$item->name,
                        'time'=>$item->created_at



                        ]);}

                        $newcategoryarray= Numberofcategory::
                        where('created_at','>',$previous_category_number->created_at)->orderBy("created_at",'DESC')
                       ->get();
                          // $previous_category_number->update([
                          //  "numberofcategories"=>$currnt_category_number
                         //  ]);
                 return view('category.index')->with('category',$category)->
              with('newcategoryarray',$newcategoryarray)->with('messageofadding',' new category  is added');

            }
                else{
                    return view('category.index')->with('category',$category);}
    }


    else {

        Numberofcategory::create(["numberofcategories"=>$currnt_category_number,
        'newcategory'=>$newcategory->name,
        'time'=>$newcategory->created_at
    ]);

        return view('category.index')->with('messageofadding','these is all categories')->with('category',$category);
    }}
else{$category=Category::all();
    return view('category.index')->with('category',$category)->with('messageofadding','these is no categories');
}
    --}}

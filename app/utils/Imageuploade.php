<?php
  namespace App\utils;
  use Illuminate\Http\Request;
 class Imageuploade{
public static function uploadeImage( $request){

$photo =$request->photo;
$photoname=time().$photo->getClientOriginalName();
$photo->move('categoryImage',$photoname);


return 'categoryImage/'.$photoname;



}

 }

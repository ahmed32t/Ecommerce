@extends('layouts.app')
@section('content')


<div class="jumbotron container">

    <p>products</p>
    <a class="btn btn-primary btn-lg" href="{{route('seller.trash')}}" role="button"> trash </a>
    <a class="btn btn-primary btn-lg" href="{{route('home.index')}}" role="button">back to home  </a>

    <a class="btn btn-primary btn-lg" href="{{route('seller.create')}}" role="button"> create </a>
    {{--
    <a class="btn btn-primary btn-lg" href="{{route('trash')}}" role="button">trash  </a>
--}}



   <!--  ##send error when you creaate -->




  <div class="container">
    <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">name</th>
            <th scope="col">price</th>
            <th scope="col">photo</th>
            <th scope="col">user name</th>
            <th scope="col">small descripe</th>
            <th scope="col">category</th>
            <th scope="col" style="width: 400px">action</th>
          </tr>
        </thead>
        <tbody>
            <!-- print the column with number   -->
            @php
            $i=0;
        @endphp

            @foreach ( $product as $item )

            <tr>
                <tr>
                    <th scope="row">{{++$i}}</th>
                    <td>{{$item->name}}</td>

                 <td>{{$item->price}}  </td>
                    <td> <img src='{{URL::asset($item->photo)}}' alt ='{{$item->photo}}' ></td>
                    <td>{{$item->user->name}}  </td>
                    <td>{{$item->small_descripe	                }}</td>

                     <td> it is product belong to sub cattegory:
                        {{ $item->subcategory->name   }}
                    . and category:{{$item->parentCategory->name   }}</td>

                    <td>




                    <div class="row">
                        <div class="col-sm">
                            <a  class="btn btn-success" href='{{route('seller.edit',['seller'=>$item->slug])}}'> Edit </a>

                        </div>



                        <div class="col-sm">
                            <a  class="btn btn-primary" href='{{route('seller.show',['seller'=>$item->slug])}}'> Show</a>

                        </div>


                            <div class="col-sm">
                                <!-- t3ml form be method delete -->
                                <form action='{{route('seller.destory',['slug'=>$item->slug])}}' method="POST">
                                  @csrf
                                  @method("DELETE")

                                    <button type="submit" class="btn btn-danger"> Delete</button>
                                    </form>
                            </div>
                          </div>






                </td>

              </tr>
            @endforeach

        </tbody>
      </table>


  </div>


@endsection


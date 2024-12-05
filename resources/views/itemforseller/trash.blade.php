@extends('layouts.app')
@section('content')


<div class="jumbotron container">

    <p>products</p>
    <a class="btn btn-primary btn-lg" href="{{route('newindex2')}}" role="button"> back </a>
    <a class="btn btn-primary btn-lg" href="{{route('home.index')}}" role="button">back to home  </a>

    <a class="btn btn-primary btn-lg" href="{{route('seller.create')}}" role="button"> create </a>



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

            @foreach ( $item as $item1 )

            <tr>
                <th scope="row">{{++$i}}</th>
                <td>{{$item1->name}}</td>

             <td>{{$item1->price}}  </td>
                <td> <img src='{{URL::asset($item1->photo)}}' alt ='{{$item1->photo}}' ></td>
                <td>{{$item1->user->name}}  </td>
                <td>{{$item1->small_descripe	                }}</td>

                <td>{{$item1->parentCategory->name   }}</td>


                <td>






                        <div class="row">
                            <div class="col-sm">
                                <a  class="btn btn-success" href='{{route('seller.restore',['slug'=>$item1->slug])}}'> restore </a>

                            </div>


                        <div class="col-sm">
                            <a  class="btn btn-primary" href='{{route('seller.show',['seller'=>$item1->slug])}}'> Show</a>

                        </div>


                            <div class="col-sm">
                                <!-- t3ml form be method delete -->
                                <form action='{{route('seller.delete',['slug'=>$item1->slug])}}' method="POST">
                                  @csrf
                                  @method("DELETE")

                                    <button type="submit" class="btn btn-danger"> Deleteforever</button>
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


@extends('layouts.app')
@section('content')


<div class="jumbotron container">

    <p>show</p>
    <a class="btn btn-primary btn-lg" href="{{route('newindex2')}}" role="button"> back   </a>
    <a class="btn btn-primary btn-lg" href="{{route('home.index')}}" role="button"> back to home  </a>

   <br>


  </div>

<br>
  <div class="container">
    <table class="table">
        <thead class="thead-dark">
          <tr>
            <tr>
                <th scope="col">#</th>
                <th scope="col">name</th>
                <th scope="col">special_name</th>
                <th scope="col">price</th>
                <th scope="col">sale</th>
                <th scope="col">user name</th>
                <th scope="col">small descripe</th>
                <th scope="col">category</th>
                <th scope="col">	description</th>

                <th scope="col">created_at</th>
                <th scope="col">updated_at</th>

                <th scope="col">	details</th>
            <th scope="col" style="width: 400px">action</th>
          </tr>
        </thead>
        <tbody>
            <!-- print the column with number   -->
            @php
            $i=0;
        @endphp



            <tr>
                <th scope="row">{{++$i}}</th>
                <td>{{$item->name}}</td>
                <td>{{$item->special_name}}  </td>

             <td>{{$item->price}}  </td>
             <td>{{$item->sale}}  </td>

                <td>{{$item->user->name}}  </td>

                <td>{{$item->small_descripe	                }}</td>


                <td> it is product belong to sub cattegory:
                    {{ $item->subcategory->name   }}
                . and category:{{$item->parentCategory->name   }}</td>


                 <td> {{$item->description}}  </td>
                 <td>created at: {{$item->created_at->format('d M Y, h:i:s A')}} </td>
            @if ($item->created_at==$item->updated_at)
                 <td> no edit happened </td>
            @else
                 <td> updated at:{{$item->updated_at->format('d M Y, h:i:s A')}}  </td>
            @endif
            <td>  {{$item->details  }}</td>
                <td>




                    <div class="row">





                          </div>






                </td>

              </tr>

        </tbody>
      </table>
      <table class="table">
        <thead class="thead-dark">
          <tr>
              <th scope="col">photo</th>
          </tr>
        </thead>
        <tbody>
          <td> <img src='{{URL::asset($item->photo)}}' alt ='{{$item->photo}}' ></td>


  </tbody>
  </table>

  </div>


@endsection


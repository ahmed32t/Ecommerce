@extends('layouts.app')
@section('content')


<div class="jumbotron container">

    <p>show</p>
    <a class="btn btn-primary btn-lg" href="{{route('newindex')}}" role="button"> back   </a>
    <a class="btn btn-primary btn-lg" href="{{route('home.index')}}" role="button"> back to home  </a>

   <br>


  </div>

<br>
  <div class="container">
    <table class="table">
        <thead class="thead-dark">
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

            @if ($category->parent_id)


            <th scope="col">	details</th>
            @endif
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
                <td>{{$category->name}}</td>
                <td>{{$category->special_name}}  </td>

             <td>{{$category->price}}  </td>
             <td>{{$category->sale}}  </td>

                <td>{{$category->user->name}}  </td>

                <td>{{$category->small_descripe	                }}</td>
                 @if ($parrentcategory)
                 <td> it is category   </td>
                 @elseif ($category->parent_id)
                 <td>these is product  belong to subcategoey :{{ $category->subcategory->name }} and
                    category :{{$category->parentCategory->name   }}</td>

                @else
                <td>these is sub category belong to category :{{$category->parentCategory->name   }}</td>
                 @endif
                 <td> {{$category->description}}  </td>
                 <td>created at: {{$category->created_at->format('d M Y, h:i:s A')}} </td>
            @if ($category->created_at==$category->updated_at)
                 <td> no edit happened </td>
            @else
                 <td> updated at:{{$category->updated_at->format('d M Y, h:i:s A')}}  </td>
            @endif
            @if ($category->parent_id  != null)


            <td> {{$category->details}}  </td>
            @endif
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
          <td> <img src='{{URL::asset($category->photo)}}' alt ='{{$category->photo}}' ></td>


  </tbody>
  </table>

  </div>


@endsection


@extends('layouts.app')
@section('content')
<div class="jumbotron container">
    <p>Create  Product</p>
    <a class="btn btn-primary btn-lg" href="{{ route('home.index') }}" role="button">Back to Home</a>
    <a class="btn btn-primary btn-lg" href="{{ route('newindex2') }}" role="button">Category</a>

    <div class="container" style="padding-top: 12%">
        <div class="card">
            <div class="card-body">
                <p class="card-text">Creating</p>
            </div>
        </div>
    </div>

    <div class="container" style="padding-top: 2%">
        <form action="{{ route('seller.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Dropdown for selecting type (Category or Product) -->
            <div class="form-group">
                <label for="type">Type</label>
                <select id="type" name="type" class="form-control" >

                    <option value="product">Product</option>

                </select>
            </div>


            <div class="form-group">
                @foreach ($subcategory as $item)
                    <input type="radio" name="parent_id" value="{{ $item->id }}" data-category-id="{{ $item->parentCategory->id }}" id="sub_category_{{ $item->id }}">
                    <label for="sub_category_{{ $item->id }}">{{ $item->name }}</label>
                @endforeach

                <!-- Hidden input to store the selected category ID -->
                <input type="hidden" name="category_id" id="selected-category-id">
            </div>





                <div class="form-group">
                    <label for="productDetail">Product Detail</label>
                    <input type="text" id="productDetail" name="details" class="form-control" placeholder="Enter product details">
                </div>


            <!-- Name input (common for both Category and Product) -->
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter name">
            </div>

            <div class="form-group">
                <label for="special_name">Special Name</label>
                <input type="text" name="special_name" class="form-control">
            </div>

            <div class="form-group">
                <label for="photo">Photo</label>
                <input type="file" name="photo" class="form-control">
            </div>

            <div class="form-group">
                <label for="small_descripe">Small Description</label>
                <textarea class="form-control" name="small_descripe" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" class="form-control" step="0.01" min="0">
            </div>

            <div class="form-group">
                <label for="sale">Sale</label>
                <input type="number" name="sale" class="form-control" step="0.01" min="0" max="100">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelectorAll('input[name="parent_id"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            // Get the selected radio button's data-category-id attribute
            var categoryId = this.getAttribute('data-category-id');
            // Set the hidden input value to the selected category ID
            document.getElementById('selected-category-id').value = categoryId;
        });
    });
</script>
@endsection

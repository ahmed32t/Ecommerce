@extends('layouts.app')
@section('content')
<div class="jumbotron container">
    <p>Edit Product</p>
    <a class="btn btn-primary btn-lg" href="{{ route('home.index') }}" role="button">Back to Home</a>
    <a class="btn btn-primary btn-lg" href="{{ route('newindex2') }}" role="button">Category</a>

    <div class="container" style="padding-top: 12%">
        <div class="card">
            <div class="card-body">
                <p class="card-text">Edit</p>
            </div>
        </div>
    </div>

    <div class="container" style="padding-top: 2%">
        <form action="{{ route('seller.update',['slug'=>$slug]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Type selection -->
            <div class="form-group">
                <label for="type">Type</label>
                <select id="type" name="type" class="form-control">
                    <option value="product">Product</option>
                </select>
            </div>

           <!-- Radio buttons for subcategories -->
            <div class="form-group">
                @foreach ($subcategory as $sub)
                    <input type="radio" name="parent_id" value="{{ $sub->id }}"
                           data-category-id="{{ $sub->parentCategory->id }}"
                           id="sub_category_{{ $sub->id }}"
                           {{ $sub->id == $item->parent_id ? 'checked' : '' }}>
                    <label for="sub_category_{{ $sub->id }}">{{ $sub->name }}</label>
                @endforeach

                <!-- Hidden input to store the selected category ID -->
                <input type="hidden" name="category_id" id="selected-category-id"
                       value="{{ $item->category_id }}">
            </div>

            <div class="form-group">
                <label for="productDetail">Product Detail</label>
                <input type="text" id="productDetail" name="details" class="form-control" value="{{ $item->details }}">
            </div>

            <!-- Name input -->
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" value="{{ $item->name }}">
            </div>

            <div class="form-group">
                <label for="special_name">Special Name</label>
                <input type="text" name="special_name" class="form-control" value="{{ $item->special_name }}">
            </div>

            <div class="form-group">
                <label for="photo">Photo</label>
                <input type="file" name="photo" class="form-control">
            </div>

            <div class="form-group">
                <label for="small_descripe">Small Description</label>
                <textarea class="form-control" name="small_descripe" rows="3">{{ $item->small_descripe }}</textarea>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" rows="3">{{ $item->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" name="price" class="form-control" value="{{ $item->price }}">
            </div>

            <div class="form-group">
                <label for="sale">Sale</label>
                <input type="text" name="sale" id="sale" class="form-control" value="{{ $item->sale }}">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript to handle category/subcategory selection -->
<script>
    // Function to manage category and subcategory radio button interactions
    function handleCategorySelection() {
        document.querySelectorAll('input[name="parent_id"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                // Update the hidden input with the parent category ID when a subcategory is selected
                const categoryId = this.dataset.categoryId;
                document.getElementById('selected-category-id').value = categoryId;
            });
        });
    }

    // Initialize scripts when the page loads
    document.addEventListener('DOMContentLoaded', function () {
        handleCategorySelection(); // Set up event listeners for category and subcategory selections
    });
</script>
@endsection

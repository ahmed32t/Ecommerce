@extends('layouts.app')
@section('content')
<div class="jumbotron container">
    <p>edit</p>
    <a class="btn btn-primary btn-lg" href="{{ route('home.index') }}" role="button">Back to Home</a>
    <a class="btn btn-primary btn-lg" href="{{ route('newindex') }}" role="button">Category</a>

    <div class="container" style="padding-top: 12%">
        <div class="card">
            <div class="card-body">
                <p class="card-text">edit</p>
            </div>
        </div>
    </div>

    <div class="container" style="padding-top: 2%">
        <form action="{{ route('category.update',['slug'=>$slug]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Type selection -->
            <div class="form-group">
                <label for="type">Type</label>
                <select id="type" name="type" class="form-control" onchange="showFields()">
                    <option value="">Select type</option>
                    <option value="category" {{ old('type', $type) == 'category' ? 'selected' : '' }}>Category</option>
                    <option value="sub category" {{ old('type', $type) == 'sub category' ? 'selected' : '' }}>Sub Category</option>
                    <option value="product" {{ old('type', $type) == 'product' ? 'selected' : '' }}>Product</option>
                </select>
            </div>


           <!-- Radio buttons for categories (shown when "Category" is selected) -->
<div id="sub-category-info" style="display:none;">
    <div class="form-group">
        @foreach ($parrentcategory as $category)
            <input type="radio" name="category_id" value="{{ $category->id }}"
                   id="category_{{ $category->id }}"
                   {{ $category->id == $item1->category_id ? 'checked' : '' }}>
            <label for="category_{{ $category->id }}">{{ $category->name }}</label>
        @endforeach
    </div>
</div>

<!-- Radio buttons for sub-categories (shown when "Sub Category" is selected) -->
<div id="category-info" style="display:none;">
    <div class="form-group">
        @foreach ($subcategory as $sub)
            <input type="radio" name="parent_id" value="{{ $sub->id }}"
                   data-category-id="{{ $sub->parentCategory->id }}"
                   id="sub_category_{{ $sub->id }}"
                   {{ $sub->id == $item1->parent_id ? 'checked' : '' }}>
            <label for="sub_category_{{ $sub->id }}">{{ $sub->name }}</label>
        @endforeach

        <!-- Hidden input to store the selected category ID -->
        <input type="hidden" name="category_id" id="selected-category-id"
               value="{{ $item1->category_id }}">
    </div>
</div>

            <!-- Hidden fields for product-specific information (shown only when "Product" is selected) -->
            <div id="product-info" style="display:none;">
                <div class="form-group">
                    <label for="productDetail">Product Detail</label>
                    <input type="text" id="productDetail" name="details" class="form-control" value={{ $item1->details }}>
                </div>
            </div>

            <!-- Name input (common for both Category and Product) -->
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" value="{{ $item1->name }}">
            </div>

            <div class="form-group">
                <label for="special_name">Special Name</label>
                <input type="text" name="special_name" class="form-control"
                value="{{ $item1->special_name }}">
            </div>

            <div class="form-group">
                <label for="photo">Photo</label>
                <input type="file" name="photo" class="form-control">
            </div>

            <div class="form-group">
                <label for="small_descripe">Small Description</label>
                <textarea class="form-control" name="small_descripe" rows="3">{{ $item1->small_descripe }}</textarea>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" rows="3">{{ $item1->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" name="price" class="form-control" value="{{ $item1->price }}">
            </div>

            <div class="form-group">
                <label for="sale">Sale</label>
                <input type="text" name="sale" id="sale" class="form-control" value="{{ $item1->sale }}">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript to handle showing fields and managing category/subcategory selection -->
<script>
    // Function to show/hide sections based on selected type
    function showFields() {
        var type = document.getElementById('type').value;
        var categoryInfo = document.getElementById('category-info');
        var productInfo = document.getElementById('product-info');
        var subCategoryInfo = document.getElementById('sub-category-info');

        // Show/hide sections based on selected type
        if (type === 'product') {
            categoryInfo.style.display = 'block';   // Show sub-category radio buttons
            productInfo.style.display = 'block';    // Show product info fields
            subCategoryInfo.style.display = 'none'; // Hide category radio buttons
        } else if (type === 'sub category') {
            subCategoryInfo.style.display = 'block';  // Show category radio buttons
            productInfo.style.display = 'none';        // Hide product info fields
            categoryInfo.style.display = 'none';       // Hide sub-category radio buttons
        } else {
            categoryInfo.style.display = 'none';    // Hide both
            productInfo.style.display = 'none';
            subCategoryInfo.style.display = 'none';
        }
    }

    // Function to manage category and subcategory radio button interactions
    function handleCategorySelection() {
        // Handle category radio button changes
        document.querySelectorAll('input[name="category_id"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                // Update the hidden input with the selected category ID
                document.getElementById('selected-category-id').value = this.value;
            });
        });

        // Handle subcategory radio button changes
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
        showFields(); // Initialize the visibility of sections based on current selection
        handleCategorySelection(); // Set up event listeners for category and subcategory selections
    });

    // Add an event listener to update the fields display when the type changes
    document.getElementById('type').addEventListener('change', showFields);
</script>


@endsection

@extends('layouts.app')
@section('content')
<div class="jumbotron container">
    <p>Create Category & Product</p>
    <a class="btn btn-primary btn-lg" href="{{ route('home.index') }}" role="button">Back to Home</a>
    <a class="btn btn-primary btn-lg" href="{{ route('newindex') }}" role="button">Category</a>

    <div class="container" style="padding-top: 12%">
        <div class="card">
            <div class="card-body">
                <p class="card-text">Creating</p>
            </div>
        </div>
    </div>

    <div class="container" style="padding-top: 2%">
        <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Dropdown for selecting type (Category or Product) -->
            <div class="form-group">
                <label for="type">Type</label>
                <select id="type" name="type" class="form-control" onchange="showFields()">
                    <option value="">Select type</option>
                    <option value="category">Category</option>
                    <option value="sub category">Sub Category</option>
                    <option value="product">Product</option>
                </select>
            </div>

            <!-- Radio buttons for categories (shown only when "Category" is selected) -->
            <div id="sub-category-info" style="display:none;">
                <div class="form-group">
                    @foreach ($parrentcategory as $item)
                        <input type="radio" name="category_id" value="{{ $item->id }}" id="category_{{ $item->id }}">
                        <label for="category_{{ $item->id }}">{{ $item->name }}</label>
                    @endforeach
                </div>
            </div>

            <!-- Radio buttons for sub-categories (shown only when "Sub Category" is selected) -->
            <div id="category-info" style="display:none;">
                <div class="form-group">
                    @foreach ($subcategory as $item)
                        <input type="radio" name="parent_id" value="{{ $item->id }}" data-category-id="{{ $item->parentCategory->id }}" id="sub_category_{{ $item->id }}">
                        <label for="sub_category_{{ $item->id }}">{{ $item->name }}</label>
                    @endforeach

                    <!-- Hidden input to store the selected category ID -->
                    <input type="hidden" name="category_id" id="selected-category-id">
                </div>
            </div>

            <!-- Hidden fields for product-specific information (shown only when "Product" is selected) -->
            <div id="product-info" style="display:none;">
                <div class="form-group">
                    <label for="productDetail">Product Detail</label>
                    <input type="text" id="productDetail" name="details" class="form-control" placeholder="Enter product details">
                </div>
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
    function showFields() {
        var type = document.getElementById('type').value;
        var categoryInfo = document.getElementById('category-info');
        var productInfo = document.getElementById('product-info');
        var subCategoryInfo = document.getElementById('sub-category-info');

        if (type === 'product') {
            categoryInfo.style.display = 'block';   // Show category radio buttons
            productInfo.style.display = 'block';
            subCategoryInfo.style.display = 'none';
        } else if (type === 'sub category') {
            subCategoryInfo.style.display = 'block';  // Show sub-category radio buttons
            productInfo.style.display = 'none';
            categoryInfo.style.display = 'none';
        } else {
            categoryInfo.style.display = 'none';    // Hide both if none selected
            productInfo.style.display = 'none';
            subCategoryInfo.style.display = 'none';
        }
    }

    // Update hidden input with selected category ID from sub-category radio buttons
    document.querySelectorAll('input[name="parent_id"]').forEach((radio) => {
        radio.addEventListener('change', function() {
            document.getElementById('selected-category-id').value = this.getAttribute('data-category-id');
        });
    });

    // Update hidden input with selected category ID from category radio buttons
    document.querySelectorAll('input[name="category_id"]').forEach((radio) => {
        radio.addEventListener('change', function() {
            document.getElementById('selected-category-id').value = this.value;
        });
    });
</script>
@endsection

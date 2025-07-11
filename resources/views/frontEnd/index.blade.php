@extends('frontEnd.layouts.master')
@section('title','Home Page')
@section('content')
<section>
    @include('frontEnd.layouts.banner')
    <br>
    <br>
    <br>
    <div class="container">
        <div class="row">
            <!-- Category Menu -->
            <div class="col-sm-3">
                <div class="category-menu">
                    <h4 class="text-center">Categories</h4>
                    <ul class="list-group">
                        @include('frontEnd.layouts.category_menu')
                    </ul>
                </div>
            </div>
            <!-- End Category Menu -->

            <!-- Product Display -->
            <div class="col-sm-9 padding-right">
                <div class="features_items">
                    <!-- Features Items -->
                    <h2 class="title text-center">Latest Products</h2>
                    <div class="row">
                        @foreach($products as $product)
                        @if($product->category->status == 1)
                        <div class="col-sm-4 mb-4">
                            <div class="product-card shadow-sm rounded">
                                <div class="product-image-wrapper position-relative">
                                    <a href="{{ url('/product-detail', $product->id) }}">
                                        <img class="img-fluid rounded-top" src="{{ url('products/small/', $product->image) }}" alt="{{ $product->p_name }}" />
                                    </a>
                                    <!-- Hover Buttons -->
                                    <div class="product-hover-buttons">
                                        <a href="{{ url('/product-detail', $product->id) }}" class="btn btn-primary btn-sm">View Product</a>

                                    </div>
                                </div>
                                <div class="product-info text-center p-3">
                                    <h4 class="product-name">{{ $product->p_name }}</h4>
                                    <p class="product-price">PKR. {{ number_format($product->price, 0, ',', '.') }}</p>
                                    <!-- Ratings -->
                                    <div class="product-rating mb-2">
                                        <span class="text-warning">&#9733;&#9733;&#9733;&#9733;&#9734;</span>
                                        (4.0)
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                <!-- End Features Items -->
            </div>
            <!-- End Product Display -->
        </div>
    </div>
    @include('frontEnd.layouts.brand')
</section>

<!-- Custom CSS -->
<style>
    .category-menu ul {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px;
        background-color: #f9f9f9;
    }

    .category-menu ul li {
        padding: 10px;
        font-size: 14px;
    }

    .product-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.3s ease-in-out;
        background-color: #fff;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .product-image-wrapper {
        position: relative;
    }

    .product-image-wrapper img {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    .product-hover-buttons {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none;
        z-index: 10;
    }

    .product-image-wrapper:hover .product-hover-buttons {
        display: block;
    }

    .product-info {
        background-color: #fff;
    }

    .product-name {
        font-size: 16px;
        font-weight: 500;
        color: #333;
        margin-bottom: 8px;
    }

    .product-price {
        font-size: 18px;
        font-weight: bold;
        color: #ff6f61;
    }

    .product-rating {
        font-size: 14px;
    }

    .product-rating span {
        font-size: 16px;
    }
</style>
@endsection

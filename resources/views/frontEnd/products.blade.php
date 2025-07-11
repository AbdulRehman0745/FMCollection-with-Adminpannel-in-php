@extends('frontEnd.layouts.master')
@section('title','List Products')
@section('slider')
@endsection
@section('content')
<br>
<br>
<div class="container">
    <div class="row">
        <!-- Sidebar for Category Menu -->
        <div class="col-sm-3">
            @include('frontEnd.layouts.category_menu')
        </div>
        <!-- Product List Section -->
        <div class="col-sm-9 padding-right">
            <div class="features_items"><!--features_items-->
                <?php
                    if ($byCate != "") {
                        $products = $list_product;
                        echo '<h2 class="title text-center">Category: '.$byCate->name.'</h2>';
                    } else {
                        echo '<h2 class="title text-center">List of Products</h2>';
                    }
                ?>
                <div class="row">
                    @foreach($products as $product)
                        @if($product->category->status == 1)
                            <!-- Single Product Card -->
                            <div class="col-sm-4 mb-4">
                                <div class="product-card">
                                    <div class="product-image-wrapper">
                                        <div class="product-hover">
                                            <a href="{{url('/product-detail', $product->id)}}">
                                                <img src="{{url('products/small/', $product->image)}}" class="product-img" alt="Product Image">
                                            </a>
                                            <div class="view-button">
                                                <a href="{{url('/product-detail', $product->id)}}" class="btn btn-primary">View Product</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-info text-center mt-2">
                                        <h4 class="product-name">{{$product->p_name}}</h4>
                                        <p class="product-price">Rp. {{$product->price}}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div><!--features_items-->
        </div>
    </div>
</div>
<br>
<br>
@endsection

<!-- Custom CSS and Animations -->
<style>
/* Global container spacing */
.container {
    font-family: Arial, sans-serif;
}

/* Section Title Styling */
.title {
    font-size: 26px;
    color: #333;
    margin-bottom: 30px;
    font-weight: bold;
}

/* Product Card Styling */
.product-card {
    border: 1px solid #e1e1e1;
    border-radius: 8px;
    overflow: hidden;
    background-color: #fff;
    transition: box-shadow 0.3s ease;
}
.product-card:hover {
    box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
}

/* Product Image Styling */
.product-image-wrapper {
    position: relative;
    overflow: hidden;
    height: 250px;
    border-bottom: 1px solid #ddd;
}
.product-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.product-card:hover .product-img {
    transform: scale(1.1);
}

/* Hover Overlay with "View Product" Button */
.product-hover {
    position: relative;
    height: 100%;
    overflow: hidden;
}
.product-hover:hover .view-button {
    opacity: 1;
    transform: translateY(0);
}
.view-button {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%) translateY(100px);
    opacity: 0;
    transition: all 0.4s ease-in-out;
}
.view-button a {
    text-decoration: none;
    font-size: 16px;
    color: #fff;
    padding: 10px 20px;
    background-color: #007bff;
    border-radius: 5px;
}
.view-button a:hover {
    background-color: #0056b3;
}

/* Product Info Section */
.product-info {
    padding: 10px;
    background-color: #f9f9f9;
    border-top: 1px solid #e1e1e1;
}
.product-name {
    font-size: 18px;
    font-weight: bold;
    color: #333;
    margin: 0;
}
.product-price {
    color: #007bff;
    font-size: 16px;
    margin-top: 5px;
}

/* Category Menu Styling */
@include('frontEnd.layouts.category_menu') {
    background-color: #f5f5f5;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

/* Responsive Design */
@media (max-width: 768px) {
    .product-card {
        margin-bottom: 20px;
    }
    .product-hover {
        height: auto;
    }
}
</style>

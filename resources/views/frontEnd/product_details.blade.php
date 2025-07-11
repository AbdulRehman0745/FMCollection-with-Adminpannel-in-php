@extends('frontEnd.layouts.master')
@section('title','Product Detail Page')
@section('slider')
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                @include('frontEnd.layouts.category_menu')
            </div>
            <div class="col-sm-9 padding-right">
                @if(Session::has('message'))
                    <div class="alert alert-success text-center" role="alert">
                        {{ Session::get('message') }}
                    </div>
                @endif

                <!-- Product Details Section -->
                <div class="product-details animated fadeInUp">
                    <div class="col-sm-6">
                        <!-- Zoomable Product Image -->
                        <div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                            <a href="{{ url('products/large', $detail_product->image) }}">
                                <img src="{{ url('products/small', $detail_product->image) }}" alt="" id="dynamicImage" class="img-fluid main-image" />
                            </a>
                        </div>
                        <!-- Thumbnail Images -->
                        <ul class="thumbnails mt-3">
                            @foreach($imagesGalleries as $imagesGallery)
                                <li class="d-inline-block mx-2">
                                    <a href="{{ url('products/large', $imagesGallery->image) }}" data-standard="{{ url('products/small', $imagesGallery->image) }}">
                                        <img src="{{ url('products/small', $imagesGallery->image) }}" alt="" width="75" class="img-thumbnail thumbnail-hover">
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="col-sm-6">
                        <form action="{{ route('addToCart') }}" method="post" role="form">
                            @csrf
                            <input type="hidden" name="products_id" value="{{ $detail_product->id }}">
                            <input type="hidden" name="product_name" value="{{ $detail_product->p_name }}">
                            <input type="hidden" name="product_code" value="{{ $detail_product->p_code }}">
                            <input type="hidden" name="product_color" value="{{ $detail_product->p_color }}">
                            <input type="hidden" name="price" value="{{ $detail_product->price }}" id="dynamicPriceInput">

                            <!-- Product Info -->
                            <div class="product-information">
                                <h2 class="product-title">{{ $detail_product->p_name }}</h2>
                                <p><strong>Product Code:</strong> {{ $detail_product->p_code }}</p>
                                <p><strong>Condition:</strong> New</p>
                                <p><strong>Price:</strong> <span id="dynamic_price">Rp.{{ $detail_product->price }}</span></p>

                                <!-- Size Dropdown -->
                                <div class="form-group">
                                    <label for="idSize"><strong>Select Size:</strong></label>
                                    <select name="size" id="idSize" class="form-control">
                                        <option value="">Select Size</option>
                                        @foreach($detail_product->attributes as $attrs)
                                            <option value="{{ $detail_product->id }}-{{ $attrs->size }}">{{ $attrs->size }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Quantity and Add to Cart -->
                                <div class="d-flex align-items-center mt-3">
                                    <label for="inputStock" class="mr-2"><strong>Quantity:</strong></label>
                                    <input type="number" name="quantity" value="1" id="inputStock" class="form-control w-25" min="1">
                                    @if($totalStock > 0)
                                        <button type="submit" class="btn btn-primary ml-3 animated-hover" id="buttonAddToCart">
                                            <i class="fa fa-shopping-cart"></i> Add to Cart
                                        </button>
                                    @else
                                        <span class="text-danger ml-3">Out of Stock</span>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- End Product Details Section -->

                <!-- Tabbed Content for Details -->
                <div class="category-tab shop-details-tab mt-5">
                    <div class="col-sm-12">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#details" data-toggle="tab">Details</a></li>
                            <li><a href="#specifications" data-toggle="tab">Specifications</a></li>
                            <li><a href="#reviews" data-toggle="tab">Reviews</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="details">
                            <p>{{ $detail_product->description }}</p>
                        </div>
                        <div class="tab-pane fade" id="specifications">
                            <p>Product specifications will go here.</p>
                        </div>
                        <div class="tab-pane fade" id="reviews">
                            <p>User reviews will go here.</p>
                        </div>
                    </div>
                </div>

                <!-- Recommended Items Section -->
                <div class="recommended_items mt-5">
                    <h2 class="title text-center">Recommended Items</h2>
                    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($relateProducts->chunk(3) as $chunk)
                                <div class="item {{ $loop->first ? 'active' : '' }}">
                                    @foreach($chunk as $item)
                                        <div class="col-sm-4">
                                            <div class="product-image-wrapper">
                                                <div class="single-products">
                                                    <div class="productinfo text-center">
                                                        <img src="{{ url('products/small', $item->image) }}" alt="" class="img-fluid animated-hover">
                                                        <h2>{{ $item->price }}</h2>
                                                        <p>{{ $item->p_name }}</p>
                                                        <a href="{{ url('/product-detail', $item->id) }}" class="btn btn-default add-to-cart">View Product</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                        <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
        .product-title {
            font-size: 24px;
            font-weight: bold;
        }
        .product-information p {
            margin-bottom: 10px;
        }
        .animated-hover:hover {
            transform: scale(1.05);
            transition: all 0.3s ease-in-out;
        }
        .thumbnail-hover:hover {
            border: 2px solid #ff6600;
            transition: border 0.3s ease-in-out;
        }
    </style>
@endsection

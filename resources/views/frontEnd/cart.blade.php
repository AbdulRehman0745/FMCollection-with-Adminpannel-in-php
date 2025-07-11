@extends('frontEnd.layouts.master')
@section('title','Cart Page')
@section('slider')
@endsection
@section('content')

<style>
    /* General Styling */
    body {
        font-family: 'Arial', sans-serif;
    }

    #cart_items .cart_menu {
        background-color: #f7f7f7;
        color: #333;
        font-weight: bold;
    }

    .cart_info table {
        margin-top: 20px;
        border: 1px solid #ddd;
    }

    .cart_info th, .cart_info td {
        text-align: center;
        vertical-align: middle;
    }

    .cart_info td.cart_product img {
        border-radius: 8px;
        transition: transform 0.3s ease-in-out;
    }

    .cart_info td.cart_product img:hover {
        transform: scale(1.1);
    }

    .cart_description h4 a {
        color: #337ab7;
        font-weight: bold;
    }

    .cart_description h4 a:hover {
        text-decoration: underline;
    }

    .cart_price p, .cart_total p {
        font-size: 18px;
        color: #333;
        font-weight: bold;
    }

    .cart_quantity_button a {
        color: #fff;
        background-color: #337ab7;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 16px;
        font-weight: bold;
        text-decoration: none;
        transition: background-color 0.3s ease-in-out;
    }

    .cart_quantity_button a:hover {
        background-color: #23527c;
    }

    .cart_quantity_input {
        text-align: center;
        width: 50px;
        margin: 0 5px;
    }

    .cart_quantity_delete {
        color: #d9534f;
        font-size: 20px;
        transition: color 0.3s ease-in-out;
    }

    .cart_quantity_delete:hover {
        color: #c9302c;
    }

    #do_action .heading h3 {
        color: #333;
        font-weight: bold;
        margin-bottom: 20px;
    }

    #do_action .btn-primary {
        background-color: #5cb85c;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        transition: background-color 0.3s ease-in-out;
    }

    #do_action .btn-primary:hover {
        background-color: #449d44;
    }

    .total_area ul {
        list-style: none;
        padding: 0;
    }

    .total_area ul li {
        font-size: 18px;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
    }

    .btn-default.check_out {
        background-color: #337ab7;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: bold;
        text-transform: uppercase;
        transition: background-color 0.3s ease-in-out;
    }

    .btn-default.check_out:hover {
        background-color: #23527c;
    }

    /* Animations */
    .cart_menu, .cart_info tr, #do_action {
        animation: fadeInUp 0.7s ease-in-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<section id="cart_items">
    <div class="container">
        @if(Session::has('message'))
            <div class="alert alert-success text-center" role="alert">
                {{Session::get('message')}}
            </div>
        @endif
        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Item</td>
                        <td class="description"></td>
                        <td class="price">Price</td>
                        <td class="quantity">Quantity</td>
                        <td class="total">Total</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart_datas as $cart_data)
                        <?php
                            $image_products=DB::table('products')->select('image')->where('id',$cart_data->products_id)->get();
                        ?>
                        <tr>
                            <td class="cart_product">
                                @foreach($image_products as $image_product)
                                    <a href=""><img src="{{url('products/small',$image_product->image)}}" alt="" style="width: 100px;"></a>
                                @endforeach
                            </td>
                            <td class="cart_description">
                                <h4><a href="">{{$cart_data->product_name}}</a></h4>
                                <p>{{$cart_data->product_code}} | {{$cart_data->size}}</p>
                            </td>
                            <td class="cart_price">
                                <p>PKR.{{$cart_data->price}}</p>
                            </td>
                            <td class="cart_quantity">
                                <div class="cart_quantity_button">
                                    <!-- Increment Quantity Button -->
                                    <a href="{{ route('cart.updateQuantity', ['id' => $cart_data->id, 'quantity' => $cart_data->quantity + 1]) }}" class="cart_quantity_up"> + </a>

                                    <!-- Display Current Quantity (Allowing Manual Editing) -->
                                    <input class="cart_quantity_input" type="text" name="quantity" value="{{ $cart_data->quantity }}" autocomplete="off" size="2">

                                    <!-- Decrement Quantity Button (Only If Quantity > 1) -->
                                    @if($cart_data->quantity > 1)
                                        <a href="{{ route('cart.updateQuantity', ['id' => $cart_data->id, 'quantity' => $cart_data->quantity - 1]) }}" class="cart_quantity_down"> - </a>
                                    @endif
                                </div>
                            </td>
                            <td class="cart_total">
                                <p class="cart_total_price">PKR. {{$cart_data->price*$cart_data->quantity}}</p>
                            </td>
                            <td class="cart_delete">
                                <a class="cart_quantity_delete" href="{{route('cart.deleteItem',$cart_data->id)}}"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<section id="do_action">
    <div class="container">
        <div class="heading">
            <h3>What would you like to do next?</h3>
            <p>Choose if you have a discount code or reward points you want to use or would like to estimate your delivery cost.</p>
        </div>
        <div class="row">
            <div class="col-sm-6">
                @if(Session::has('message_coupon'))
                    <div class="alert alert-danger text-center" role="alert">
                        {{Session::get('message_coupon')}}
                    </div>
                @endif
                <div class="chose_area" style="padding: 20px;">
                    <form action="{{url('/apply-coupon')}}" method="post" role="form">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="Total_amountPrice" value="{{$total_price}}">
                        <div class="form-group">
                            <label for="coupon_code">Coupon Code</label>
                            <div class="controls {{$errors->has('coupon_code')?'has-error':''}}">
                                <input type="text" class="form-control" name="coupon_code" id="coupon_code" placeholder="Promotion By Coupon">
                                <span class="text-danger">{{$errors->first('coupon_code')}}</span>
                            </div>
                            <button type="submit" class="btn btn-primary">Apply</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-6">
                @if(Session::has('message_apply_sucess'))
                    <div class="alert alert-success text-center" role="alert">
                        {{Session::get('message_apply_sucess')}}
                    </div>
                @endif
                <div class="total_area">
                    <ul>
                        @if(Session::has('discount_amount_price'))
                            <li>Sub Total <span>PKR. {{$total_price}}</span></li>
                            <li>Coupon Discount (Code : {{Session::get('coupon_code')}}) <span>Rp. {{Session::get('discount_amount_price')}}</span></li>
                            <li>Total <span>PKR. {{$total_price-Session::get('discount_amount_price')}}</span></li>
                        @else
                            <li>Total <span>PKR. {{$total_price}}</span></li>
                        @endif
                    </ul>
                    <div style="margin-left: 20px;">
                        <a class="btn btn-default check_out" href="{{url('/check-out')}}">Check Out</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

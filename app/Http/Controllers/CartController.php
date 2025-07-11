<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Cart_model;
use App\ProductAtrr_model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Show Cart
    public function index(){
        $session_id = Session::get('session_id');
        $cart_datas = Cart_model::where('session_id', $session_id)->get();
        $total_price = 0;

        foreach ($cart_datas as $cart_data) {
            $total_price += $cart_data->price * $cart_data->quantity;
        }

        return view('frontEnd.cart', compact('cart_datas', 'total_price'));
    }

    // Add item to cart
    public function addToCart(Request $request) {
        $inputToCart = $request->all();
        Session::forget('discount_amount_price');
        Session::forget('coupon_code');

        if ($inputToCart['size'] == "") {
            return back()->with('message', 'Please select Size');
        } else {
            $stockAvailable = DB::table('product_att')
                ->select('stock', 'sku')
                ->where([
                    'products_id' => $inputToCart['products_id'],
                    'price' => $inputToCart['price']
                ])->first();

            if ($stockAvailable->stock >= $inputToCart['quantity']) {
                $inputToCart['user_email'] = 'abdul23lm@gmail.com';
                $session_id = Session::get('session_id');

                if (empty($session_id)) {
                    // Use Str::random() instead of str_random()
                    $session_id = \Illuminate\Support\Str::random(40);
                    Session::put('session_id', $session_id);
                }

                $inputToCart['session_id'] = $session_id;
                $sizeAtrr = explode("-", $inputToCart['size']);
                $inputToCart['size'] = $sizeAtrr[1];
                $inputToCart['product_code'] = $stockAvailable->sku;

                $count_duplicateItems = Cart_model::where([
                    'products_id' => $inputToCart['products_id'],
                    'product_color' => $inputToCart['product_color'],
                    'size' => $inputToCart['size']
                ])->count();

                if ($count_duplicateItems > 0) {
                    return back()->with('message', 'This Item Added already');
                } else {
                    Cart_model::create($inputToCart);
                    return back()->with('message', 'Add To Cart Already');
                }
            } else {
                return back()->with('message', 'Stock is not Available!');
            }
        }
    }

    // Delete item from the cart
    public function deleteItem($id) {
        $cartItem = Cart_model::find($id);

        if ($cartItem) {
            // Delete the cart item
            $cartItem->delete();
            return back()->with('message', 'Item removed from cart.');
        }

        return back()->with('message', 'Item not found.');
    }

    // Update item quantity in the cart
    public function updateQuantity($id, $quantity) {
        $cartItem = Cart_model::find($id);

        if ($cartItem) {
            // Update the quantity
            if ($quantity <= 0) {
                return back()->with('message', 'Quantity must be greater than 0.');
            }

            $cartItem->quantity = $quantity;
            $cartItem->save();
            return back()->with('message', 'Quantity updated successfully.');
        }

        return back()->with('message', 'Item not found.');
    }
}

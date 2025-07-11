<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckOutController extends Controller
{
    public function index(){
        $countries = DB::table('countries')->get();
        $user_login = User::where('id', Auth::id())->first();
        return view('checkout.index', compact('countries', 'user_login'));
    }

    public function submitcheckout(Request $request)
    {
        // Check if the user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Please log in to proceed with checkout.');
        }

        // Validate the checkout data
        $this->validate($request, [
            'billing_name' => 'required',
            'billing_address' => 'required',
            'billing_city' => 'required',
            'billing_state' => 'required',
            'billing_pincode' => 'required',
            'billing_mobile' => 'required',
            'shipping_name' => 'required',
            'shipping_address' => 'required',
            'shipping_city' => 'required',
            'shipping_state' => 'required',
            'shipping_pincode' => 'required',
            'shipping_mobile' => 'required',
        ]);

        // Get input data
        $input_data = $request->all();

        // Check if shipping address already exists for the user
        $count_shippingaddress = DB::table('delivery_address')->where('users_id', Auth::id())->count();

        if ($count_shippingaddress == 1) {
            // Update existing shipping address
            DB::table('delivery_address')->where('users_id', Auth::id())->update([
                'name' => $input_data['shipping_name'],
                'address' => $input_data['shipping_address'],
                'city' => $input_data['shipping_city'],
                'state' => $input_data['shipping_state'],
                'country' => $input_data['shipping_country'],
                'pincode' => $input_data['shipping_pincode'],
                'mobile' => $input_data['shipping_mobile']
            ]);
        } else {
            // Insert new shipping address
            DB::table('delivery_address')->insert([
                'users_id' => Auth::id(),
                'users_email' => Session::get('frontSession'), // Assuming this session holds the user's email
                'name' => $input_data['shipping_name'],
                'address' => $input_data['shipping_address'],
                'city' => $input_data['shipping_city'],
                'state' => $input_data['shipping_state'],
                'country' => $input_data['shipping_country'],
                'pincode' => $input_data['shipping_pincode'],
                'mobile' => $input_data['shipping_mobile'],
            ]);
        }

        // Update user billing information
        DB::table('users')->where('id', Auth::id())->update([
            'name' => $input_data['billing_name'],
            'address' => $input_data['billing_address'],
            'city' => $input_data['billing_city'],
            'state' => $input_data['billing_state'],
            'country' => $input_data['billing_country'],
            'pincode' => $input_data['billing_pincode'],
            'mobile' => $input_data['billing_mobile']
        ]);

        // Redirect to the order review page
        return redirect('/order-review')->with('message', 'Checkout successfully completed!');
    }
}

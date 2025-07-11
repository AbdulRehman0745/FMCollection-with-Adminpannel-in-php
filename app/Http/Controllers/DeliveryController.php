<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Province_model;
use App\City_model;

class DeliveryController extends Controller
{
    // Get province data
    public function getprovince()
    {
        $client = new Client();

        try {
            $response = $client->get('https://api.rajaongkir.com/starter/province', [
                'headers' => [
                    'key' => '70624564ece670986d0f8ffd0e4ef282',
                ],
            ]);
        } catch (RequestException $e) {
            return response()->json(['error' => $e->getResponse()->getBody()->getContents()], 500);
        }

        $json = $response->getBody()->getContents();
        $array_result = json_decode($json, true);

        // Uncomment this if you want to save provinces to the database
        // foreach ($array_result["rajaongkir"]["results"] as $provinceData) {
        //     $province = new Province_model;
        //     $province->id = $provinceData["province_id"];
        //     $province->name = $provinceData["province"];
        //     $province->save();
        // }

        return response()->json($array_result);
    }

    // Get city data
    public function getcity()
    {
        $client = new Client();

        try {
            $response = $client->get('https://api.rajaongkir.com/starter/city', [
                'headers' => [
                    'key' => '70624564ece670986d0f8ffd0e4ef282',
                ],
            ]);
        } catch (RequestException $e) {
            return response()->json(['error' => $e->getResponse()->getBody()->getContents()], 500);
        }

        $json = $response->getBody()->getContents();
        $array_result = json_decode($json, true);

        // Save cities to the database
        foreach ($array_result["rajaongkir"]["results"] as $cityData) {
            $city = new City_model;
            $city->id = $cityData["city_id"];
            $city->name = $cityData["city_name"];
            $city->id_province = $cityData["province_id"];
            $city->save();
        }

        return response()->json(['success' => 'Cities saved successfully!']);
    }

    // Check shipping page
    public function checkshipping()
    {
        $title = "Check Shipping";
        $city = City_model::all(); // Fetch all cities

        return view('delivery.check-shipping', compact('title', 'city'));
    }

    // Process shipping calculation
    public function processShipping(Request $request)
    {
        $title = "Check Shipping Result";
        $client = new Client();

        try {
            $response = $client->request('POST', 'https://api.rajaongkir.com/starter/cost', [
                'body' => http_build_query([
                    'origin' => $request->origin,
                    'destination' => $request->destination,
                    'weight' => $request->weight,
                    'courier' => 'jne',
                ]),
                'headers' => [
                    'key' => '70624564ece670986d0f8ffd0e4ef282',
                    'content-type' => 'application/x-www-form-urlencoded',
                ],
            ]);
        } catch (RequestException $e) {
            return response()->json(['error' => $e->getResponse()->getBody()->getContents()], 500);
        }

        $json = $response->getBody()->getContents();
        $array_result = json_decode($json, true);

        // Extract origin and destination names
        $origin = $array_result["rajaongkir"]["origin_details"]["city_name"];
        $destination = $array_result["rajaongkir"]["destination_details"]["city_name"];

        return view('delivery.check-shipping-result', compact('title', 'origin', 'destination', 'array_result'));
    }
}

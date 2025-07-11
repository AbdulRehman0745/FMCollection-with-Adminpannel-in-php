<?php

namespace App\Http\Controllers;

use App\ImageGallery_model;
use App\Products_model;
use Illuminate\Http\Request;

class ImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputData = $request->all();
        if ($request->file('image')) {
            $images = $request->file('image');
            foreach ($images as $image) {
                if ($image->isValid()) {
                    $extension = $image->getClientOriginalExtension();
                    $filename = rand(100, 999999) . time() . '.' . $extension;

                    // Define paths for large, medium, and small images
                    $large_image_path = public_path('products/large/' . $filename);
                    $medium_image_path = public_path('products/medium/' . $filename);
                    $small_image_path = public_path('products/small/' . $filename);

                    // Create image resource from file (for different formats)
                    if ($extension == 'jpg' || $extension == 'jpeg') {
                        $src_image = imagecreatefromjpeg($image);
                    } elseif ($extension == 'png') {
                        $src_image = imagecreatefrompng($image);
                    } elseif ($extension == 'gif') {
                        $src_image = imagecreatefromgif($image);
                    } else {
                        return back()->with('message', 'Unsupported image format!');
                    }

                    // Resize and save large image
                    $large_width = imagesx($src_image);
                    $large_height = imagesy($src_image);
                    $large_image = imagecreatetruecolor($large_width, $large_height);
                    imagecopyresampled($large_image, $src_image, 0, 0, 0, 0, $large_width, $large_height, $large_width, $large_height);
                    imagejpeg($large_image, $large_image_path);

                    // Resize and save medium image (600x600)
                    $medium_width = 600;
                    $medium_height = 600;
                    $medium_image = imagecreatetruecolor($medium_width, $medium_height);
                    imagecopyresampled($medium_image, $src_image, 0, 0, 0, 0, $medium_width, $medium_height, $large_width, $large_height);
                    imagejpeg($medium_image, $medium_image_path);

                    // Resize and save small image (300x300)
                    $small_width = 300;
                    $small_height = 300;
                    $small_image = imagecreatetruecolor($small_width, $small_height);
                    imagecopyresampled($small_image, $src_image, 0, 0, 0, 0, $small_width, $small_height, $large_width, $large_height);
                    imagejpeg($small_image, $small_image_path);

                    // Free up memory
                    imagedestroy($src_image);
                    imagedestroy($large_image);
                    imagedestroy($medium_image);
                    imagedestroy($small_image);

                    // Store image data in the database
                    $inputData['image'] = $filename;
                    ImageGallery_model::create($inputData);
                }
            }
        }
        return back()->with('message', 'Add Images Successed');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $menu_active = 3;
        $product = Products_model::findOrFail($id);
        $imageGalleries = ImageGallery_model::where('products_id', $id)->get();
        return view('backEnd.products.add_images_gallery', compact('menu_active', 'product', 'imageGalleries'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = ImageGallery_model::findOrFail($id);
        $image_large = public_path() . '/products/large/' . $delete->image;
        $image_medium = public_path() . '/products/medium/' . $delete->image;
        $image_small = public_path() . '/products/small/' . $delete->image;
        if ($delete->delete()) {
            unlink($image_large);
            unlink($image_medium);
            unlink($image_small);
        }
        return back()->with('message', 'Delete Success!');
    }
}

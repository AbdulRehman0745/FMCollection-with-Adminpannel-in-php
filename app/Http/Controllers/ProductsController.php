<?php

namespace App\Http\Controllers;

use App\Category_model;
use App\Products_model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Add this import for Str class

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu_active = 3;
        $i = 0;
        $products = Products_model::orderBy('created_at', 'desc')->get();
        return view('backEnd.products.index', compact('menu_active', 'products', 'i'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menu_active = 3;
        $categories = Category_model::where('parent_id', 0)->pluck('name', 'id')->all();
        return view('backEnd.products.create', compact('menu_active', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'p_name' => 'required|min:5',
            'p_code' => 'required',
            'p_color' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:1000',
        ]);

        $formInput = $request->all();

        if ($request->file('image')) {
            $image = $request->file('image');
            if ($image->isValid()) {
                $fileName = time() . '-' . Str::slug($formInput['p_name'], '-') . '.' . $image->getClientOriginalExtension();
                $large_image_path = public_path('products/large/' . $fileName);
                $medium_image_path = public_path('products/medium/' . $fileName);
                $small_image_path = public_path('products/small/' . $fileName);

                // Resize Image using PHP's GD library
                $this->resizeImage($image, $large_image_path, 1200, 1200);  // Large Image
                $this->resizeImage($image, $medium_image_path, 600, 600);  // Medium Image
                $this->resizeImage($image, $small_image_path, 300, 300);  // Small Image

                $formInput['image'] = $fileName;
            }
        }

        Products_model::create($formInput);

        return redirect()->route('product.create')->with('message', 'Add Products Successfully!');
    }

    /**
     * Resize image
     *
     * @param  \Illuminate\Http\UploadedFile $image
     * @param  string $path
     * @param  int $width
     * @param  int $height
     * @return void
     */
    private function resizeImage($image, $path, $width, $height)
    {
        $imageResource = imagecreatefromstring(file_get_contents($image));
        $currentWidth = imagesx($imageResource);
        $currentHeight = imagesy($imageResource);

        // Create a new image with the target dimensions
        $newImage = imagecreatetruecolor($width, $height);

        // Resize the image
        imagecopyresampled($newImage, $imageResource, 0, 0, 0, 0, $width, $height, $currentWidth, $currentHeight);

        // Save the image
        imagejpeg($newImage, $path, 90);  // Quality 90 for JPEG images
        imagedestroy($imageResource);
        imagedestroy($newImage);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu_active = 3;
        $categories = Category_model::where('parent_id', 0)->pluck('name', 'id')->all();
        $edit_product = Products_model::findOrFail($id);
        $edit_category = Category_model::findOrFail($edit_product->categories_id);
        return view('backEnd.products.edit', compact('edit_product', 'menu_active', 'categories', 'edit_category'));
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
        $update_product = Products_model::findOrFail($id);

        $this->validate($request, [
            'p_name' => 'required|min:5',
            'p_code' => 'required',
            'p_color' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'image|mimes:png,jpg,jpeg|max:1000',
        ]);

        $formInput = $request->all();

        if ($update_product['image'] == '') {
            if ($request->file('image')) {
                $image = $request->file('image');
                if ($image->isValid()) {
                    $fileName = time() . '-' . Str::slug($formInput['p_name'], '-') . '.' . $image->getClientOriginalExtension();
                    $large_image_path = public_path('products/large/' . $fileName);
                    $medium_image_path = public_path('products/medium/' . $fileName);
                    $small_image_path = public_path('products/small/' . $fileName);

                    // Resize Image using PHP's GD library
                    $this->resizeImage($image, $large_image_path, 1200, 1200);  // Large Image
                    $this->resizeImage($image, $medium_image_path, 600, 600);  // Medium Image
                    $this->resizeImage($image, $small_image_path, 300, 300);  // Small Image

                    $formInput['image'] = $fileName;
                }
            }
        } else {
            $formInput['image'] = $update_product['image'];
        }

        $update_product->update($formInput);
        return redirect()->route('product.index')->with('message', 'Update Products Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Products_model::findOrFail($id);
        $image_large = public_path() . '/products/large/' . $delete->image;
        $image_medium = public_path() . '/products/medium/' . $delete->image;
        $image_small = public_path() . '/products/small/' . $delete->image;

        if ($delete->delete()) {
            unlink($image_large);
            unlink($image_medium);
            unlink($image_small);
        }

        return redirect()->route('product.index')->with('message', 'Delete Success!');
    }

    public function deleteImage($id)
    {
        $delete_image = Products_model::findOrFail($id);
        $image_large = public_path() . '/products/large/' . $delete_image->image;
        $image_medium = public_path() . '/products/medium/' . $delete_image->image;
        $image_small = public_path() . '/products/small/' . $delete_image->image;

        if ($delete_image) {
            $delete_image->image = '';
            $delete_image->save();
            // Delete image files
            unlink($image_large);
            unlink($image_medium);
            unlink($image_small);
        }

        return back();
    }
}

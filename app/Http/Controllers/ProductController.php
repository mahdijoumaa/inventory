<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;




use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Facades\Image;
use function PHPUnit\Framework\fileExists;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
             //
       //  $products = Product::orderBy('id', 'asc')->get();
    //    return view('products.index2', compact('products'));
      $products = Product::with(['category', 'supplier'])->get();
    return view('products.index2', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
       $categories = Category::all();
    $suppliers = Supplier::all();
    return view('products.create', compact('categories', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /*

      // ✅ Validation
    $request->validate([
        'product_name'  => 'required|string|unique:products',
        'product_code'  => 'required|string|unique:products',
        'cat_id'        => 'required|integer|exists:categories,id',
        'supp_id'       => 'required|integer|exists:suppliers,id',
        'brand'         => 'nullable|string',
        'product_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // ✅ Default image
    $imageName = 'no_image.png';

    // ✅ Upload folder path
    $path = public_path('upload');

    // ✅ Create folder if not exists
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }

    // ✅ Check if user uploaded image
    if ($request->hasFile('product_image')) {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($request->file('product_image'));

        // Optional resize if needed
        // $image->scale(width: 600);

        $imageName = uniqid() . '.' . $request->file('product_image')->getClientOriginalExtension();
        $image->save($path . '/' . $imageName);
    }



    
    // ✅ Save to DB
    Product::create([
        'product_name'  => $request->product_name,
        'product_code'  => $request->product_code,
        'cat_id'        => $request->cat_id,
        'supp_id'       => $request->supp_id,
        'brand'         => $request->brand,
        'product_image' => $imageName,
    ]);

    return redirect()->route('products.index')
        ->with('success', 'Product added successfully ✅');

        */

           // ✅ Validation
    $request->validate([
        'product_name'  => 'required|string|unique:products',
        'product_code'  => 'required|string|unique:products',
        'cat_id'        => 'nullable|integer|exists:categories,id',
        'supp_id'       => 'nullable|integer|exists:suppliers,id',
        'brand'         => 'nullable|string',
        'unit'          => 'nullable|string',
        'cost_price'    => 'nullable|numeric|min:0',
        'sell_price'    => 'nullable|numeric|min:0',
        'vat'           => 'nullable|numeric|min:0',
        'barcode'       => 'nullable|string',
        'location'      => 'nullable|string',
        'min_stock'     => 'nullable|integer|min:0',
        'max_stock'     => 'nullable|integer|min:0',
        'expiry_date'   => 'nullable|date',
        'is_active'     => 'nullable|boolean',
        'description'   => 'nullable|string',
        'product_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // ✅ Default image
    $imageName = 'no_image.png';

    // ✅ Upload folder path
    $path = public_path('upload');
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }

    // ✅ Check if user uploaded image
    if ($request->hasFile('product_image')) {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($request->file('product_image'));

        $imageName = uniqid() . '.' . $request->file('product_image')->getClientOriginalExtension();
        $image->save($path . '/' . $imageName);
    }

    // ✅ Save to DB
    Product::create([
        'product_name'  => $request->product_name,
        'product_code'  => $request->product_code,
        'cat_id'        => $request->cat_id ?? 1, // default to Unassigned
        'supp_id'       => $request->supp_id ?? 1, // default to Unassigned
        'brand'         => $request->brand,
        'unit'          => $request->unit,
        'cost_price'    => $request->cost_price ?? 0,
        'sell_price'    => $request->sell_price ?? 0,
        'vat'           => $request->vat ?? 0,
        'barcode'       => $request->barcode,
        'location'      => $request->location,
        'min_stock'     => $request->min_stock ?? 0,
        'max_stock'     => $request->max_stock ?? 0,
        'expiry_date'   => $request->expiry_date,
        'is_active'     => $request->has('is_active') ? 1 : 0,
        'description'   => $request->description,
        'product_image' => $imageName,
    ]);

    return redirect()->route('products.index')
        ->with('success', 'Product added successfully ✅');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
         $product = Product::findOrFail($id);
        $categories = Category::all();
        $suppliers = Supplier::all();

        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        /*
        $product = Product::findOrFail($id);

        // Validation
        $request->validate([
            'product_name'  => 'required|string',
            'product_code'  => 'required|string|unique:products,product_code,' . $id,
            'cat_id'        => 'required|integer',
            'supp_id'       => 'required|integer',
            'brand'         => 'nullable|string',
            'product_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Default image
        $imageName = $product->product_image;
        $path = public_path('upload');
        if (!file_exists($path)) mkdir($path, 0777, true);

        if ($request->hasFile('product_image')) {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($request->file('product_image'));
            $imageName = uniqid() . '.' . $request->file('product_image')->getClientOriginalExtension();
            $image->save($path . '/' . $imageName);
        }

        $product->update([
            'product_name'  => $request->product_name,
            'product_code'  => $request->product_code,
            'cat_id'        => $request->cat_id,
            'supp_id'       => $request->supp_id,
            'brand'         => $request->brand,
            'product_image' => $imageName,
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully ✅'); */
            $product = Product::findOrFail($id);

    // Validation
    $request->validate([
        'product_name'  => 'required|string',
        'product_code'  => 'required|string|unique:products,product_code,' . $id,
        'cat_id'        => 'required|integer',
        'supp_id'       => 'required|integer',
        'brand'         => 'nullable|string',
        'unit'          => 'required|string',
        'cost_price'    => 'nullable|numeric',
        'sell_price'    => 'nullable|numeric',
        'vat'           => 'nullable|numeric',
        'barcode'       => 'nullable|string',
        'location'      => 'nullable|string',
        'min_stock'     => 'nullable|integer',
        'max_stock'     => 'nullable|integer',
        'expiry_date'   => 'nullable|date',
        'is_active'     => 'nullable|boolean',
        'description'   => 'nullable|string',
        'product_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Default image
    $imageName = $product->product_image;
    $path = public_path('upload');
    if (!file_exists($path)) mkdir($path, 0777, true);

    // Handle image upload
    if ($request->hasFile('product_image')) {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($request->file('product_image'));
        $imageName = uniqid() . '.' . $request->file('product_image')->getClientOriginalExtension();
        $image->save($path . '/' . $imageName);
    }

    // Update product
    $product->update([
        'product_name'  => $request->product_name,
        'product_code'  => $request->product_code,
        'cat_id'        => $request->cat_id,
        'supp_id'       => $request->supp_id,
        'brand'         => $request->brand,
        'unit'          => $request->unit,
        'cost_price'    => $request->cost_price,
        'sell_price'    => $request->sell_price,
        'vat'           => $request->vat ?? 0,
        'barcode'       => $request->barcode,
        'location'      => $request->location,
        'min_stock'     => $request->min_stock ?? 0,
        'max_stock'     => $request->max_stock,
        'expiry_date'   => $request->expiry_date,
        'is_active'     => $request->has('is_active') ? 1 : 0,
        'description'   => $request->description,
        'product_image' => $imageName,
    ]);

    return redirect()->route('products.index')->with('success', 'Product updated successfully ✅');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
         // Find product
    $product = Product::findOrFail($id);

    // Path to upload folder
    $path = public_path('upload');

    // Delete image if not default
    if ($product->product_image != 'no_image.png' && file_exists($path . '/' . $product->product_image)) {
        unlink($path . '/' . $product->product_image);
    }

    // Delete product record
    $product->delete();

    // Redirect back with success message
    return redirect()->route('products.index')
        ->with('success', 'Product deleted successfully ✅');
    }
}

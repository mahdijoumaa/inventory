<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

 use App\Models\Category;

 use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;



class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
          $Categories = Category::orderBy('id', 'asc')->get();

    // 2. Pass suppliers to the Blade view
    return view('categories.index', compact('Categories'));
        
      
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
         return view('categories.cat_add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
         // ✅ Validation
    $request->validate([
        'cat_name'  => 'required|string|max:255|unique:categories,cat_name',
        'cat_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // ✅ Default image
    $imageName = 'no_image.png';

    // ✅ Upload folder
    $path = public_path('upload/');

    // ✅ Create folder if not exists
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }

    // ✅ Check if image uploaded
    if ($request->hasFile('cat_image')) {

        $manager = new ImageManager(new Driver());

        $image = $manager->read($request->file('cat_image'));

        // 🔥 Resize (recommended)
        $image->resize(300, 300);

        // ✅ Unique name
        $imageName = Str::uuid() . '.' . $request->file('cat_image')->getClientOriginalExtension();

        // ✅ Save image
        $image->save($path . '/' . $imageName);
    }

    // ✅ Save to DB
    Category::create([
        'cat_name'  => $request->cat_name,
        'cat_image' => $imageName,
    ]);

    return redirect()
        ->route('categories.index')
        ->with('success', 'Category added successfully ✅');
        
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
         // ✅ Find the category or fail
    $category = Category::findOrFail($id);

    // ✅ Return the edit view with the category
    return view('categories.edit', compact('category'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

          $category = Category::findOrFail($id);

    // ✅ Validate input
    $request->validate([
        'cat_name'  => 'required|string|unique:categories,cat_name,' . $category->id,
        'cat_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // ✅ Default image
    $imageName = $category->cat_image ?? 'no_image.png';

    // ✅ Upload folder path
    $path = public_path('upload/categories');

    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }

    // ✅ Check if new image uploaded
    if ($request->hasFile('cat_image')) {

        // Delete old image if exists and not default
        if ($category->cat_image && file_exists($path . '/' . $category->cat_image)) {
            unlink($path . '/' . $category->cat_image);
        }

        $manager = new ImageManager(new Driver());
        $image = $manager->read($request->file('cat_image'));

        $imageName = uniqid() . '.' . $request->file('cat_image')->getClientOriginalExtension();
        $image->save($path . '/' . $imageName);
    }

    // ✅ Update DB
    $category->update([
        'cat_name'  => $request->cat_name,
        'cat_image' => $imageName,
    ]);

    return redirect()->route('categories.index')
                     ->with('success', 'Category updated successfully ✅');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
         // ✅ Find category
    $category = Category::findOrFail($id);

    // ✅ Path to images folder
    $path = public_path('upload');

    // 🔥 Delete old image (if not default)
    if ($category->cat_image != 'no_image.png' &&
        file_exists($path . '/' . $category->cat_image)) {

        unlink($path . '/' . $category->cat_image);
    }

    // ✅ Now delete category
    $category->delete();

    // ✅ Redirect back with success message
    return redirect()->route('categories.index')
                     ->with('success', 'Category deleted successfully.');
    }
}

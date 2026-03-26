<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;


use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Facades\Image;
use function PHPUnit\Framework\fileExists;





class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->query('perPage', 5); // default 5

        if ($perPage == -1) {
            // Get all suppliers without pagination
            $suppliers = Supplier::orderBy('id')->get();
        } else {
            $suppliers = Supplier::orderBy('id')->paginate($perPage);
        }

        return view('supplier.index', compact('suppliers', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('supplier.add_supplier');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $request->validate([
    'supp_name'    => 'required|string|unique:suppliers',
    'supp_email'   => 'required|string',
    'supp_phone'   => 'required|string',
    'supp_address' => 'required|string',
    'supp_image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
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
if ($request->hasFile('supp_image')) {

    // Create manager
    $manager = new ImageManager(new Driver());

    // Read image
    $image = $manager->read($request->file('supp_image'));

    // Optional resize (recommended)
    // $image->scale(width: 600);

    // Unique filename
    $imageName = uniqid() . '.' . $request->file('supp_image')->getClientOriginalExtension();

    // Save image
    $image->save($path . '/' . $imageName);
}

// ✅ Save to DB
Supplier::create([
    'supp_name'    => $request->supp_name,
    'supp_email'   => $request->supp_email,
    'supp_phone'   => $request->supp_phone,
    'supp_address' => $request->supp_address,
    'supp_image'   => $imageName,
]);

return redirect()->route('supplier.index')
    ->with('success', 'Supplier added successfully ✅');

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

        // Find the supplier by ID
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return redirect()->route('supplier.index')->with('error', 'Supplier not found.');
        }

        // Return the edit view with supplier data
        return view('supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

      $supplier = Supplier::find($id);

    if (!$supplier) {
        return redirect()->route('supplier.index')
            ->with('error', 'Supplier not found.');
    }

    // ✅ Validation
    $request->validate([
        'supp_name'    => 'required|string|unique:suppliers,supp_name,' . $supplier->id,
        'supp_email'   => 'required|email',
        'supp_phone'   => 'required|string',
        'supp_address' => 'required|string',
        'supp_image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // ✅ Update basic fields
    $supplier->supp_name    = $request->supp_name;
    $supplier->supp_email   = $request->supp_email;
    $supplier->supp_phone   = $request->supp_phone;
    $supplier->supp_address = $request->supp_address;

    // ✅ Upload folder
    $path = public_path('upload');

    // ✅ Ensure folder exists
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }

    // ✅ Handle image upload
    if ($request->hasFile('supp_image')) {

        // 🔥 Delete old image (if not default)
        if ($supplier->supp_image != 'no_image.png' &&
            file_exists($path . '/' . $supplier->supp_image)) {

            unlink($path . '/' . $supplier->supp_image);
        }

        // ✅ Intervention Image
        $manager = new ImageManager(new Driver());
        $image   = $manager->read($request->file('supp_image'));

        // Optional resize
        // $image->scale(width: 600);

        // Unique filename
        $imageName = uniqid() . '.' . $request->file('supp_image')->getClientOriginalExtension();

        // Save image
        $image->save($path . '/' . $imageName);

        // Save to DB
        $supplier->supp_image = $imageName;
    }

    $supplier->save();

    return redirect()->route('supplier.index')
        ->with('success', 'Supplier updated successfully ✅');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        // Find the supplier by ID
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return redirect()->route('supplier.index')->with('error', 'Supplier not found.');
        }

        // Delete the supplier
        $supplier->delete();

        // Redirect back with success message
        return redirect()->route('supplier.index')->with('success', 'Supplier deleted successfully.');
    }
}

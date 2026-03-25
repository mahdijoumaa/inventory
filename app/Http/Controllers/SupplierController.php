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
        //

        $request->validate([
            'supp_name' => 'required|string|unique:suppliers',
            'supp_email' => 'required|string',
            'supp_phone' => 'required|string',
            'supp_address' => 'required|string',
            'supp_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);


        // ✅ Create manager (v3 style)
        $manager = new ImageManager(new Driver());

        // ✅ Read image (THIS replaces make())
        $image = $manager->read($request->file('supp_image'));

        // ✅ Resize (v3 uses scale instead of resize)
        //  $image->scale(width: 600);

        // Generate filename
        $imageName = time() . '.' . $request->file('supp_image')->getClientOriginalExtension();

        // ✅ Save image
        $image->save(public_path('upload/' . $imageName));



        $supplier = new Supplier();
        $supplier->supp_name = $request->supp_name;
        $supplier->supp_email = $request->supp_email;
        $supplier->supp_phone = $request->supp_phone;
        $supplier->supp_address = $request->supp_address;
        $supplier->supp_image = $imageName;
        $supplier->save();



        return redirect()->route('supplier.index')->with('success', '');

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
            return redirect()->route('supplier.index')->with('error', 'Supplier not found.');
        }

        // Validate request
        $request->validate([
            'supp_name' => 'required|string|unique:suppliers,supp_name,' . $supplier->id,
            'supp_email' => 'required|email',
            'supp_phone' => 'required|string',
            'supp_address' => 'required|string',
            'supp_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update supplier fields
        $supplier->supp_name = $request->supp_name;
        $supplier->supp_email = $request->supp_email;
        $supplier->supp_phone = $request->supp_phone;
        $supplier->supp_address = $request->supp_address;

        // Handle image if uploaded
        if ($request->hasFile('supp_image')) {
            // Delete old image if exists
            if ($supplier->supp_image && file_exists(public_path('upload/' . $supplier->supp_image))) {
                unlink(public_path('upload/' . $supplier->supp_image));
            }

            $imageName = time() . '.' . $request->supp_image->extension();
            $request->supp_image->move(public_path('upload/'), $imageName);
            $supplier->supp_image = $imageName;
        }

        $supplier->save();

        return redirect()->route('supplier.index')->with('success', 'Supplier updated successfully.');
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;






use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Facades\Image;
use function PHPUnit\Framework\fileExists;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
         $customers = Customer::orderBy('id', 'asc')->get();
        return view('customer.index2', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('customer.add_customer');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
         $request->validate([
            'cust_name'    => 'required|string|unique:customers',
            'cust_email'   => 'required|string',
            'cust_phone'   => 'required|string',
            'cust_address' => 'required|string',
            'cust_image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imageName = 'no_image.png';
        $path = public_path('upload');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        if ($request->hasFile('cust_image')) {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($request->file('cust_image'));

            $imageName = uniqid() . '.' . $request->file('cust_image')->getClientOriginalExtension();
            $image->save($path . '/' . $imageName);
        }

        Customer::create([
            'cust_name'    => $request->cust_name,
            'cust_email'   => $request->cust_email,
            'cust_phone'   => $request->cust_phone,
            'cust_address' => $request->cust_address,
            'cust_image'   => $imageName,
        ]);

        return redirect()->route('customer.index')
            ->with('success', 'Customer added successfully ✅');
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
        $customer = Customer::find($id);

        if (!$customer) {
            return redirect()->route('customer.index')->with('error', 'Customer not found.');
        }

        return view('customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $customer = Customer::find($id);

        if (!$customer) {
            return redirect()->route('customer.index')
                ->with('error', 'Customer not found.');
        }

        $request->validate([
            'cust_name'    => 'required|string|unique:customers,cust_name,' . $customer->id,
            'cust_email'   => 'required|email',
            'cust_phone'   => 'required|string',
            'cust_address' => 'required|string',
            'cust_image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $customer->cust_name    = $request->cust_name;
        $customer->cust_email   = $request->cust_email;
        $customer->cust_phone   = $request->cust_phone;
        $customer->cust_address = $request->cust_address;

        $path = public_path('upload');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        if ($request->hasFile('cust_image')) {

            if ($customer->cust_image != 'no_image.png' &&
                file_exists($path . '/' . $customer->cust_image)) {

                unlink($path . '/' . $customer->cust_image);
            }

            $manager = new ImageManager(new Driver());
            $image = $manager->read($request->file('cust_image'));

            $imageName = uniqid() . '.' . $request->file('cust_image')->getClientOriginalExtension();
            $image->save($path . '/' . $imageName);

            $customer->cust_image = $imageName;
        }

        $customer->save();

        return redirect()->route('customer.index')
            ->with('success', 'Customer updated successfully ✅');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        $customer = Customer::findOrFail($id);

        $path = public_path('upload');

        if ($customer->cust_image != 'no_image.png' &&
            file_exists($path . '/' . $customer->cust_image)) {

            unlink($path . '/' . $customer->cust_image);
        }

        $customer->delete();

        return redirect()->route('customer.index')
            ->with('success', 'Customer deleted successfully.');
    }
}

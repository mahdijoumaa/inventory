<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;


use App\Models\Purchase;
use App\Models\PurchaseMeta;

use Illuminate\Support\Facades\DB;

 use App\Models\Unit;
class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $suppliers = Supplier::all();
        $categories  = Category::all();
        $units=Unit::all();

          $products=Product::all();
          $page_title = "Purchase";


        return view('purchase.create',compact('suppliers','categories','units','products'));



    }
     // AJAX
    public function getProducts(Request $request)
    {
        return Product::where('id', $request->cat_id)
            ->where('id', $request->supplier_id)
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

             $request->validate([
            'supplier_id' => 'required',
            'product_id.*' => 'required',
            'qty.*' => 'required|numeric|min:1',
            'unit_price.*' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {

            // Create Purchase
            $purchase = Purchase::create([
                'purchase_no'  => 'PUR-' . time(),
                'supplier_id'  => $request->supplier_id,
                'total_amount' => $request->total_amount,
                'paid_amount'  => $request->paid_amount ?? 0,
                'due_amount'   => $request->due_amount ?? 0,
            ]);

            // Loop items
            foreach ($request->product_id as $key => $product_id) {

                PurchaseMeta::create([
                    'purchase_id' => $purchase->id,
                    'product_id'  => $product_id,
                    'unit_id'     => $request->unit_id[$key],
                    'qty'         => $request->qty[$key],
                    'unit_price'  => $request->unit_price[$key],
                ]);

                // OPTIONAL: update stock
                // Product::where('id', $product_id)->increment('stock', $request->qty[$key]);
            }

            DB::commit();

            return redirect()->route('purchases.index')
                ->with('success', 'Purchase saved successfully ✅');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

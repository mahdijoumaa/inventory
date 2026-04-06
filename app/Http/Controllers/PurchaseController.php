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
      
        $purchase_no=$this->uniqueNumber();
        $pade_title = '';
        //  $suppliers = Supplier::where('status',1)->get();
        $suppliers = Supplier::all();
        $categories = Category::all();
        $units = Unit::all();
        $products = Product::all();



    
        return view('purchase.create',compact('purchase_no','pade_title','suppliers','categories','units','products'));

    }
   
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
    
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

/*
    public function uniqueNumber()

    {
        $purchase =Purchase::latest()->first();

        if($purchase->count()> 1)
            {
                $name=  $purchase->purchase_no;
                $number=explode('_',$name);
                  $purchase_no= 'ps_'+ ((int)$number[1]+1);

            }
            else
                {
               $purchase_no = 'ps_0001';

                }

                return $purchase_no;


    }
                */


public function uniqueNumber()
{
    $purchase = Purchase::latest()->first();

    if ($purchase) {
        $name = $purchase->purchase_no;
        $number = explode('_', $name);

        $next = ((int)($number[1] ?? 0)) + 1;

        $purchase_no = 'PS_' . str_pad($next, 4, '0', STR_PAD_LEFT);
    } else {
        $purchase_no = 'PS_0001';
    }

    return $purchase_no;
}

}

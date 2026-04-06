<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;


use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use App\Models\Purchase;
use App\Models\PurchaseMeta;

use Illuminate\Support\Facades\DB;

 use App\Models\Unit;
class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
         $query = Purchase::with('supplier')->latest();

        // search text
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('purchase_no', 'like', "%{$search}%")
                  ->orWhere('total_amount', 'like', "%{$search}%")
                  ->orWhere('paid_amount', 'like', "%{$search}%")
                  ->orWhere('due_amount', 'like', "%{$search}%")
                  ->orWhereHas('supplier', function ($sq) use ($search) {
                      $sq->where('supp_name', 'like', "%{$search}%");
                  });
            });
        }

        // status filter
        if ($request->filled('status')) {
            if ($request->status === 'paid') {
                $query->where('due_amount', '<=', 0);
            } elseif ($request->status === 'partial') {
                $query->where('paid_amount', '>', 0)
                      ->where('due_amount', '>', 0);
            } elseif ($request->status === 'due') {
                $query->where('paid_amount', '<=', 0)
                      ->where('due_amount', '>', 0);
            }
        }

        // date from
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        // date to
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $purchases = $query->paginate(10)->withQueryString();

        $totalPurchases = (clone $query)->count();
        $totalAmount = (clone $query)->sum('total_amount');
        $totalPaid = (clone $query)->sum('paid_amount');
        $totalDue = (clone $query)->sum('due_amount');

        return view('purchase.index', compact(
            'purchases',
            'totalPurchases',
            'totalAmount',
            'totalPaid',
            'totalDue'
        ));

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
       
    $request->validate([
            'purchase_id'   => 'required|string|max:255',
            'supp_id'       => 'required',
            'total'         => 'required|numeric|min:0',
            'paid_amount'   => 'nullable|numeric|min:0',

            'cat_id'        => 'required|array|min:1',
            'cat_id.*'      => 'required',

            'unit'          => 'required|array|min:1',
            'unit.*'        => 'required',

            'quantity'      => 'required|array|min:1',
            'quantity.*'    => 'required|numeric|min:1',

            'price'         => 'required|array|min:1',
            'price.*'       => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $paidAmount = (float) ($request->paid_amount ?? 0);
            $totalAmount = (float) $request->total;
            $dueAmount = $totalAmount - $paidAmount;

            if ($dueAmount < 0) {
                $dueAmount = 0;
            }

            // save purchase header
            $purchase = Purchase::create([
                'purchase_no'  => $request->purchase_id,
                'supplier_id'  => $request->supp_id,
                'total_amount' => $totalAmount,
                'paid_amount'  => $paidAmount,
                'due_amount'   => $dueAmount,
            ]);

            // save purchase detail rows
            foreach ($request->cat_id as $index => $categoryId) {
                $qty = $request->quantity[$index] ?? 0;
                $unitPrice = $request->price[$index] ?? 0;
                $unitId = $request->unit[$index] ?? null;

                if (!$categoryId || !$unitId || $qty <= 0) {
                    continue;
                }

                PurchaseMeta::create([
                    'purchase_id' => $purchase->id,
                    'category_id' => $categoryId,
                    'qty'         => $qty,
                    'unit_price'  => $unitPrice,
                    'unit_id'     => $unitId,
                ]);
            }

            DB::commit();

            return redirect()->route('purchase.index')->with('success', 'Purchase saved successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('error', $e->getMessage());
    }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
            $purchase = Purchase::with([
        'supplier',
        'metas.category',
        'metas.unit',
    ])->findOrFail($id);

    return view('purchase.show', compact('purchase'));
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
public function printSingle($id)
{
    $purchase = Purchase::with([
        'supplier',
        'metas.category',
        'metas.unit'
    ])->findOrFail($id);

    return view('purchase.print_single', compact('purchase'));
}



public function downloadPdf($id)
{
    $purchase = Purchase::with([
        'supplier',
        'metas.category',
        'metas.unit',
    ])->findOrFail($id);

    $qrText = 'Purchase No: ' . $purchase->purchase_no
        . ' | Supplier: ' . ($purchase->supplier->supp_name ?? 'N/A')
        . ' | Total: ' . number_format((float)$purchase->total_amount, 2);

    $qrCode = base64_encode(
        QrCode::format('svg')->size(120)->generate($qrText)
    );

    $pdf = Pdf::loadView('purchase.pdf', compact('purchase', 'qrCode'))
        ->setPaper('a4', 'portrait');

    return $pdf->download('purchase_' . $purchase->purchase_no . '.pdf');
}


}

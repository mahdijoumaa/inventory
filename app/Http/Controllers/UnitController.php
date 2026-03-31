<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

 use App\Models\Unit;

 use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

         //
          $Units = Unit::orderBy('id', 'asc')->get();

    // 2. Pass suppliers to the Blade view
    return view('unit.index', compact('Units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
          return view('unit.unit_add'); // make sure your blade is resources/views/units/create.blade.php
}

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
          $request->validate([
            'unit_name'  => 'required|string|max:255|unique:units,unit_name',
            'unit_notes' => 'nullable|string',
        ]);

        Unit::create([
            'unit_name'  => $request->unit_name,
            'unit_notes' => $request->unit_notes,
        ]);

        return redirect()->route('unit.index')
            ->with('success', 'Unit created successfully ✅');
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
           $unit = Unit::findOrFail($id);
        return view('unit.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
           $unit = Unit::findOrFail($id);

        $request->validate([
            'unit_name'  => 'required|string|max:255|unique:units,unit_name,' . $id,
            'unit_notes' => 'nullable|string',
        ]);

        $unit->update([
            'unit_name'  => $request->unit_name,
            'unit_notes' => $request->unit_notes,
        ]);

        return redirect()->route('unit.index')
            ->with('success', 'Unit updated successfully ✅');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
         $unit = Unit::findOrFail($id);

    // Example check (if you relate units to products later)
  if ($unit->products()->count() > 0) {
    return back()->with('error', 'Cannot delete unit, it is in use ❌');
}

    $unit->delete();

    return redirect()->route('unit.index')
        ->with('success', 'Unit deleted successfully ✅');
    }
}

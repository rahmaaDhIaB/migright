<?php

namespace App\Http\Controllers;

use App\DataTables\RegionDataTable;
use App\Models\Category;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RegionDataTable $dataTable)
    {
        return $dataTable->render('regions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('regions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        Region::create([
            'name' => $request->name
        ]);
        return redirect()->route('regions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $region = Region::findOrFail($id);
        return view('regions.show', compact('region'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $region = Region::findOrFail($id);
        return view('regions.edit', compact('region'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $region = Region::findOrFail($id);
        $region->update([
            'name' => $request->name
        ]);
        return redirect()->route('regions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $region = Region::findOrFail($id);
        foreach ($region->services as $service) {
            $service->delete();
        }
        $region->delete();
        return redirect()->route('regions.index');
    }
}

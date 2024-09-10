<?php

namespace App\Http\Controllers;

use App\DataTables\NewsDataTable;
use App\DataTables\TypeDataTable;
use App\Models\News;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TypeDataTable $dataTable)
    {
        return $dataTable->render('types.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('types.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type_fr' => 'required|string|max:255',
            'type_ar' => 'required|string|max:255',
            'type_en' => 'required|string|max:255',
            'category' => 'required|in:assistance,testimony,lost-person',
        ]);

        $type = Type::create($request->all());

        return redirect()->route('types.index')
            ->with('success', 'Type created successfully.');
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
        $type = Type::findOrFail($id);
        return view('types.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'type_fr' => 'required|string|max:255',
            'type_ar' => 'required|string|max:255',
            'type_en' => 'required|string|max:255',
            'category' => 'required|in:assistance,testimony,lost-person',
        ]);

        $type = Type::findOrFail($id);

        $type->update($request->all());

        return redirect()->route('types.index')
            ->with('success', 'Type updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $types = Type::findOrFail($id);
        $types->delete();
        return redirect()->route('types.index')->with('success', __('deleted_successfully'));
    }
}

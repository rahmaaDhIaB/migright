<?php

namespace App\Http\Controllers;

use App\DataTables\ServiceDataTable;
use App\Models\Category;
use App\Models\Region;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ServiceDataTable $dataTable)
    {
        return $dataTable->render('services.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $regions = Region::all();
        return view('services.create', compact('categories', 'regions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'region_id' => 'required',
            'description' => 'required',
            'address' => 'required',
            'contact' => 'nullable|string',
            'location_url' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $service = Service::create([
            'name' => $request->name ,
            'category_id' => $request->category_id ,
            'region_id' => $request->region_id ,
            'description' => $request->description ,
            'address' => $request->address ,
            'contact' => $request->contact ,
            'location_url' => $request->location_url ,
        ]);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file_name = time() . $file->getClientOriginalName();
            $file->move(storage_path('app/public/uploads/images'), $file_name);
            $service->image = $file_name;
            $service->save();
        }
        return redirect()->route('services.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $service = Service::findOrFail($id);
        return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $categories = Category::all();
        $regions = Region::all();
        return view('services.edit', compact('service' , 'categories', 'regions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'region_id' => 'required',
            'description' => 'required',
            'address' => 'required',
            'contact' => 'nullable|string',
            'location_url' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $service = Service::findOrFail($id);
        $service->update([
            'name' => $request->name ,
            'category_id' => $request->category_id ,
            'region_id' => $request->region_id ,
            'description' => $request->description ,
            'address' => $request->address ,
            'contact' => $request->contact ,
            'location_url' => $request->location_url ,
        ]);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file_name = time() . $file->getClientOriginalName();
            $file->move(storage_path('app/public/uploads/images'), $file_name);
            $service->image = $file_name;
            $service->save();
        }
        return redirect()->route('services.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return redirect()->route('services.index');
    }
}

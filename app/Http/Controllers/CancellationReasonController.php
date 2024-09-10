<?php

namespace App\Http\Controllers;

use App\DataTables\CancellationReasonDataTable;
use App\Models\CancellationReason;
use Illuminate\Http\Request;

class CancellationReasonController extends Controller
{
    public function index(CancellationReasonDataTable $dataTable)
    {
        return $dataTable->render('cancellation-reasons.index');
    }

    public function create()
    {
        return view('cancellation-reasons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        CancellationReason::create($request->all());
        return redirect()->route('cancellation-reasons.index');
    }

    public function show($id)
    {
        $cancellationReason = CancellationReason::findOrFail($id);
        return view('cancellation-reasons.show', compact('cancellationReason'));
    }

    public function edit($id)
    {
        $cancellationReason = CancellationReason::findOrFail($id);
        return view('cancellation-reasons.edit',compact('cancellationReason'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $cancellationReason = CancellationReason::findOrFail($id);
        $cancellationReason->update($request->all());
        return redirect()->route('cancellation-reasons.index');
    }

    public function destroy($id)
    {
        CancellationReason::destroy($id);
        return redirect()->route('cancellation-reasons.index');
    }
}

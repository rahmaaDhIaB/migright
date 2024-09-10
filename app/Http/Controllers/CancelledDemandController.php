<?php

namespace App\Http\Controllers;

use App\DataTables\CancelledDemandDataTable;
use App\Models\Demand;
use Illuminate\Http\Request;

class CancelledDemandController extends Controller
{
    public function index(CancelledDemandDataTable $dataTable)
    {
        return $dataTable->render('cancelled-demands.index');
    }

    public function show($id)
    {
        $demand = Demand::findOrFail($id);
        $type = $demand->types()->first();

        switch ($demand->demandable_type) {
            case 'App\Models\LostPersonDemand' :
                $lostPersonDemand = $demand->demandable ;
                return view('cancelled-demands.lost-person', compact('lostPersonDemand','type'));
            case 'App\Models\AssistanceDemand' :
                $assistanceDemand = $demand->demandable;
                return view('cancelled-demands.assistance', compact('assistanceDemand','type'));
            default :
                $testimonyDemand = $demand->demandable;
                return view('cancelled-demands.testimony', compact('testimonyDemand','type'));
        }
    }
}

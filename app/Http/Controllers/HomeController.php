<?php

namespace App\Http\Controllers;

use App\Models\Demand;
use App\Models\LostPersonDemand;
use App\Models\AssistanceDemand;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (auth('web')->user()->is_admin == 0){
            return view('partner-home') ;
        }
        $demandableTypeMap = [
            'App\Models\AssistanceDemand' => 'AssistanceDemand',
            'App\Models\TestimonyDemand' => 'TestimonyDemand',
            'App\Models\LostPersonDemand' => 'LostPersonDemand',
        ];

        $lostPersonRequests = DB::table(DB::raw('(SELECT COALESCE(region, "Non spécifié") as region, count(*) as total
                                         FROM lost_person_demands
                                         GROUP BY COALESCE(region, "Non spécifié")) as sub'))
            ->orderByRaw('CASE WHEN region = "Non spécifié" THEN 1 ELSE 0 END')
            ->get();


        $lostPersonRegions = $lostPersonRequests->pluck('region');
        $lostPersonPieChartData = $lostPersonRequests->pluck('total');

        $assistanceRequests = DB::table(DB::raw('(SELECT COALESCE(region, "Non spécifié") as region, count(*) as total
                                           FROM assistance_demands
                                           GROUP BY COALESCE(region, "Non spécifié")) as sub'))
            ->orderByRaw('CASE WHEN region = "Non spécifié" THEN 1 ELSE 0 END')
            ->get();
        $assistanceRegions = $assistanceRequests->pluck('region');
        $assistancePieChartData = $assistanceRequests->pluck('total');

        $demandsByType = DB::table('demands')
            ->select('demandable_type', DB::raw('count(*) as total'))
            ->groupBy('demandable_type')
            ->get();
        $demandLabels = $demandsByType->map(function($item) use ($demandableTypeMap) {
            return $demandableTypeMap[$item->demandable_type] ?? $item->demandable_type;
        });
        $demandData = $demandsByType->pluck('total');

        $numberOfDemands = Demand::count();
        $numberOfAssistanceDemands = Demand::where('demandable_type', 'App\Models\AssistanceDemand')->count();
        $numberOfTestimonyDemands = Demand::where('demandable_type', 'App\Models\TestimonyDemand')->count();
        $numberOfLostPersonDemands = Demand::where('demandable_type', 'App\Models\LostPersonDemand')->count();

        $demands = DB::table('demands')
            ->select(DB::raw("COUNT(*) as count"), DB::raw("MONTH(created_at) as month_name"))
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("MONTH(created_at)"), DB::raw("month_name"))
            ->orderBy(DB::raw("MONTH(created_at)"), 'ASC')
            ->pluck('count', 'month_name');

        $assistanceDemands = DB::table('demands')
            ->select(DB::raw("COUNT(*) as count"), DB::raw("MONTH(created_at) as month_name"))
            ->whereYear('created_at', date('Y'))
            ->where('demandable_type', 'App\Models\AssistanceDemand')
            ->groupBy(DB::raw("MONTH(created_at)"), DB::raw("month_name"))
            ->orderBy(DB::raw("MONTH(created_at)"), 'ASC')
            ->pluck('count', 'month_name');

        $testimonyDemands = DB::table('demands')
            ->select(DB::raw("COUNT(*) as count"), DB::raw("MONTH(created_at) as month_name"))
            ->whereYear('created_at', date('Y'))
            ->where('demandable_type', 'App\Models\TestimonyDemand')
            ->groupBy(DB::raw("MONTH(created_at)"), DB::raw("month_name"))
            ->orderBy(DB::raw("MONTH(created_at)"), 'ASC')
            ->pluck('count', 'month_name');

        $lostPersonDemands = DB::table('demands')
            ->select(DB::raw("COUNT(*) as count"), DB::raw("MONTH(created_at) as month_name"))
            ->whereYear('created_at', date('Y'))
            ->where('demandable_type', 'App\Models\LostPersonDemand')
            ->groupBy(DB::raw("MONTH(created_at)"), DB::raw("month_name"))
            ->orderBy(DB::raw("MONTH(created_at)"), 'ASC')
            ->pluck('count', 'month_name');

        $demandsData = [];
        $assistanceData = [];
        $testimonyData = [];
        $lostPersonData = [];
        for ($i = 1; $i <= 12; $i++) {
            $demandsData[] = $demands[$i] ?? 0;
            $assistanceData[] = $assistanceDemands[$i] ?? 0;
            $testimonyData[] = $testimonyDemands[$i] ?? 0;
            $lostPersonData[] = $lostPersonDemands[$i] ?? 0;
        }

        return view('home', compact(
            'numberOfDemands',
            'numberOfAssistanceDemands',
            'numberOfTestimonyDemands',
            'numberOfLostPersonDemands',
            'demandsData',
            'assistanceData',
            'testimonyData',
            'lostPersonData',
            'lostPersonRegions', 'lostPersonPieChartData',
            'assistanceRegions', 'assistancePieChartData',
            'demandLabels', 'demandData' ,'assistanceDemands' ,'testimonyDemands', 'lostPersonDemands', 'demands'
        ));
    }
}

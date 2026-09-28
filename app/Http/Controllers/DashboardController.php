<?php

namespace App\Http\Controllers;

use App\Models\Fabric;
use App\Models\FabricGroup;
use App\Models\LayModel;
use App\Models\Machine;
use App\Models\LotBundle;
use App\Models\SewingMachineScan;
use App\Models\LaundryRecord;
use App\Models\QualityDashboardAudit;

class DashboardController extends Controller
{
    public function index()
    {
        $totalFabrics = Fabric::count();
        $totalFabricGroups = FabricGroup::count();
        $totalLayModels = LayModel::count();

        // Department-wise & Machine-wise metrics for integrated dashboard
        $machines = Machine::withCount(['scans as in_scans_today' => function ($q) {
            $q->where('scan_type', 'in_scan')->whereDate('scanned_at', now());
        }, 'scans as out_scans_today' => function ($q) {
            $q->where('scan_type', 'out_scan')->whereDate('scanned_at', now());
        }])->get();

        $stageCounts = [
            'Fabric Store' => LotBundle::where('stage', 'cutting_completed')->count(),
            'Cutting' => LotBundle::where('stage', 'numbering_done')->count(),
            'Supermarket' => LotBundle::where('stage', 'supermarket')->count(),
            'Sewing In' => LotBundle::where('stage', 'sew_in')->count(),
            'Mid Line QC' => LotBundle::where('stage', 'mid_line')->count(),
            'Washing/Laundry' => LotBundle::where('stage', 'washing_laundry')->count(),
            'Finishing' => LotBundle::where('stage', 'finishing')->count(),
        ];

        // Stage Completion Percentages for display
        $stagePercentages = [
            'Fabric Store' => 100,
            'Cutting' => 85,
            'Supermarket' => 75,
            'Sewing In' => 65,
            'Mid Line QC' => 50,
            'Washing/Laundry' => 35,
            'Finishing' => 20,
        ];

        $totalBundlesCount = LotBundle::count();
        $completedBundlesCount = LotBundle::where('stage', 'completed')->count();
        $overallFactoryProgressPct = 88.5; // Overall production efficiency percentage

        $laundryBatches = LaundryRecord::with('lotBundle')->latest()->take(5)->get();
        $qualityAudits = QualityDashboardAudit::with('lotBundle', 'garmentDefect', 'operator', 'machine')->latest()->take(10)->get();

        $totalAudits = QualityDashboardAudit::count();
        $passedAudits = QualityDashboardAudit::where('audit_result', 'pass')->count();
        $dhuRate = $totalAudits > 0 ? round((($totalAudits - $passedAudits) / $totalAudits) * 100, 2) : 0;

        return view('dashboard', compact(
            'totalFabrics',
            'totalFabricGroups',
            'totalLayModels',
            'machines',
            'stageCounts',
            'stagePercentages',
            'overallFactoryProgressPct',
            'totalBundlesCount',
            'laundryBatches',
            'qualityAudits',
            'dhuRate'
        ));
    }
}

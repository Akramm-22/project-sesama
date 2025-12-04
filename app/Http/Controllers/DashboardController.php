<?php

namespace App\Http\Controllers;

use App\Models\Recipient;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRecipients = Recipient::count();
        $distributedCount = Recipient::where('is_distributed', true)->count();
        $pendingCount = $totalRecipients - $distributedCount;



        $recentDistributions = Recipient::where('is_distributed', true)
            ->orderBy('distributed_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'totalRecipients',
            'distributedCount',
            'pendingCount',
            'recentDistributions'
        ));
    }

    public function dashboarduser()
    {
        $totalRecipients = Recipient::count();
        $distributedCount = Recipient::where('is_distributed', true)->count();
        $pendingCount = $totalRecipients - $distributedCount;

        $recentDistributions = Recipient::where('is_distributed', true)
            ->orderBy('distributed_at', 'desc')
            ->limit(10)
            ->get();

        return view('pemantau.dashboard', compact(
            'totalRecipients',
            'distributedCount',
            'pendingCount',
            'recentDistributions'
        ));
    }
}

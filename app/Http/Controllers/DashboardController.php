<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService
    ) {}

    public function index(Request $request)
    {
        $dashboardData = $this->dashboardService->getDashboardData();

        return view('home', $dashboardData->toArray());
    }
}
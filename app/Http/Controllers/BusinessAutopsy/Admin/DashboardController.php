<?php

namespace App\Http\Controllers\BusinessAutopsy\Admin;

use App\Http\Controllers\Controller;
use App\Services\BusinessAutopsy\AdminDashboardService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(private readonly AdminDashboardService $dashboard) {}

    public function __invoke(): View
    {
        return view('business-autopsy.admin.dashboard', [
            'summary' => $this->dashboard->summary(),
        ]);
    }
}

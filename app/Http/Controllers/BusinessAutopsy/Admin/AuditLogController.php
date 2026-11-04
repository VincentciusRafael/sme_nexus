<?php

namespace App\Http\Controllers\BusinessAutopsy\Admin;

use App\Http\Controllers\Controller;
use App\Services\BusinessAutopsy\AuditLogService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLogs) {}

    public function index(Request $request): View
    {
        return view('business-autopsy.admin.audit.index', [
            'logs' => $this->auditLogs->paginate($request->only(['search', 'entity_type'])),
            'filters' => $request->only(['search', 'entity_type']),
        ]);
    }
}

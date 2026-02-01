<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;

class AuditLogController extends Controller
{
    public function index()
    {
        $logs = AuditLog::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return view('admin.audit-logs.index', compact('logs'));
    }
}

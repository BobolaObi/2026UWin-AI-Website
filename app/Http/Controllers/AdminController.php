<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(Request $request): View
    {
        AuditLog::create([
            'user_id' => $request->user()->id,
            'action' => 'admin.index',
            'details' => json_encode([
                'path' => $request->path(),
            ], JSON_THROW_ON_ERROR),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return view('admin.index');
    }
}

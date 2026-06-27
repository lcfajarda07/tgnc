<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditLogger
{
    public static function log(string $action, string $module, string $description, array $properties = [], ?Request $request = null): void
    {
        $user = Auth::user();

        AuditLog::create([
            'branch_id' => $user?->branch_id,
            'user_id' => $user?->id,
            'action' => $action,
            'module' => $module,
            'description' => $description,
            'properties' => $properties,
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\PrayerRequest;
use App\Services\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PrayerRequestController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'branch_id' => ['nullable', 'exists:branches,id'],
            'request' => ['required', 'string', 'max:5000'],
            'visibility' => ['nullable', 'in:pastoral,private,public'],
        ]);

        $validated['branch_id'] = $validated['branch_id'] ?? Branch::query()->where('code', 'PASIG')->value('id');
        $validated['visibility'] = $validated['visibility'] ?? 'pastoral';

        PrayerRequest::create($validated);

        AuditLogger::log('create', 'prayer-requests', 'Prayer request submitted from the public website.', [], $request);

        return back()->with('success', 'Your prayer request has been received. Our team will pray with you.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class UtilityPageController extends Controller
{
    public function reports(): Response
    {
        return Inertia::render('Admin/Utility', [
            'title' => 'Reports',
            'eyebrow' => 'Analytics',
            'items' => [
                ['title' => 'Attendance Reports', 'body' => 'Sunday worship, prayer meeting, Bible study, youth, and event attendance summaries.'],
                ['title' => 'Member Reports', 'body' => 'Birthdays, inactive members, ministry involvement, and branch membership growth.'],
                ['title' => 'Finance Reports', 'body' => 'Income, tithes, offerings, mission giving, expenses, cash flow, monthly, and annual views.'],
                ['title' => 'Branch Comparison', 'body' => 'Compare branches across attendance, members, events, prayer requests, and giving.'],
            ],
        ]);
    }

    public function settings(): Response
    {
        return Inertia::render('Admin/Utility', [
            'title' => 'Settings',
            'eyebrow' => 'Configuration',
            'items' => [
                ['title' => 'Church Profile', 'body' => 'Church name, tagline, contact details, logo, giving information, and social links.'],
                ['title' => 'Security', 'body' => 'Role-based access, policy checks, rate limits, audit logs, and session configuration.'],
                ['title' => 'Deployment', 'body' => 'Vercel, Neon Postgres, Supabase storage, queues, cache, and environment settings.'],
                ['title' => 'Future Mobile API', 'body' => 'Branch-scoped data and reusable resources stay ready for mobile app integration.'],
            ],
        ]);
    }
}

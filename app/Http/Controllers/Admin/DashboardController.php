<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AuditLog;
use App\Models\Branch;
use App\Models\ChurchEvent;
use App\Models\FinanceRecord;
use App\Models\Member;
use App\Models\PrayerRequest;
use App\Models\Visitor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $user = $request->user();

        $stats = [
            ['label' => 'Members', 'value' => $this->scoped(Member::query(), $user)->count(), 'trend' => '+12 this month'],
            ['label' => 'Visitors', 'value' => $this->scoped(Visitor::query(), $user)->count(), 'trend' => 'Follow-up ready'],
            ['label' => 'Attendance', 'value' => $this->scoped(Attendance::query(), $user)->whereDate('attended_at', '>=', now()->subDays(30))->count(), 'trend' => 'Last 30 days'],
            ['label' => 'Giving', 'value' => 'PHP '.number_format((float) $this->scoped(FinanceRecord::query(), $user)->where('type', 'income')->sum('amount')), 'trend' => 'Income recorded'],
            ['label' => 'Prayer', 'value' => $this->scoped(PrayerRequest::query(), $user)->where('status', 'new')->count(), 'trend' => 'New requests'],
            ['label' => 'Events', 'value' => $this->scoped(ChurchEvent::query(), $user)->where('starts_at', '>=', now())->count(), 'trend' => 'Upcoming'],
        ];

        $branches = Branch::query()
            ->withCount(['members', 'visitors', 'events', 'prayerRequests'])
            ->when(! $user->isSuperAdmin(), fn (Builder $query) => $query->whereKey($user->branch_id))
            ->orderBy('id')
            ->get();

        $moduleCards = collect(config('tgnc.modules'))->map(function (array $module, string $slug) use ($user) {
            $model = $module['model'];
            $query = $model::query();

            if ($model === Branch::class && ! $user->isSuperAdmin()) {
                $query->whereKey($user->branch_id);
            }

            if ($this->hasBranchColumn($model) && ! $user->isSuperAdmin()) {
                $query->where('branch_id', $user->branch_id);
            }

            return [
                'slug' => $slug,
                'title' => $module['title'],
                'count' => $query->count(),
                'permission' => $module['permission'],
            ];
        })->values();

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'branches' => $branches,
            'moduleCards' => $moduleCards,
            'recentActivities' => AuditLog::query()->latest()->take(8)->get(),
        ]);
    }

    private function scoped(Builder $query, $user): Builder
    {
        if (! $user->isSuperAdmin() && $this->hasBranchColumn($query->getModel()::class)) {
            $query->where('branch_id', $user->branch_id);
        }

        return $query;
    }

    private function hasBranchColumn(string $model): bool
    {
        return in_array($model, [
            Attendance::class,
            ChurchEvent::class,
            FinanceRecord::class,
            Member::class,
            PrayerRequest::class,
            Visitor::class,
        ], true);
    }
}

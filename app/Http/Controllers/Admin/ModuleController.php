<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Services\AuditLogger;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ModuleController extends Controller
{
    public function index(Request $request, string $module): Response
    {
        $config = $this->moduleConfig($module);
        $query = $this->queryFor($request, $config);

        $rows = $query
            ->latest('id')
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($row) => $this->formatRow($row, $config['fields']));

        return Inertia::render('Admin/Module', [
            'module' => [
                'slug' => $module,
                'title' => $config['title'],
                'fields' => $config['fields'],
                'permission' => $config['permission'],
            ],
            'rows' => $rows,
            'filters' => $request->only(['search', 'branch_id', 'status', 'date_from', 'date_to']),
            'branches' => Branch::query()->orderBy('name')->get(['id', 'name']),
            'modules' => collect(config('tgnc.modules'))->map(fn ($item, $slug) => ['slug' => $slug, 'title' => $item['title']])->values(),
        ]);
    }

    public function export(Request $request, string $module, string $format)
    {
        $config = $this->moduleConfig($module);
        $rows = $this->queryFor($request, $config)->limit(500)->get()->map(fn ($row) => $this->formatRow($row, $config['fields']));

        AuditLogger::log('export', $module, "Exported {$config['title']} as {$format}.", ['rows' => $rows->count()], $request);

        if ($format === 'pdf' || $format === 'print') {
            $view = view('exports.module', [
                'title' => $config['title'],
                'fields' => $config['fields'],
                'rows' => $rows,
                'generatedBy' => $request->user()->name,
            ]);

            return $format === 'print'
                ? $view
                : Pdf::loadHTML($view->render())->download($module.'-export.pdf');
        }

        return $this->csv($config['title'], $config['fields'], $rows);
    }

    private function moduleConfig(string $module): array
    {
        abort_unless(array_key_exists($module, config('tgnc.modules')), 404);

        return config("tgnc.modules.{$module}");
    }

    private function queryFor(Request $request, array $config): Builder
    {
        $model = $config['model'];
        $query = $model::query();
        $table = $query->getModel()->getTable();

        if ($model === Branch::class && ! $request->user()->isSuperAdmin()) {
            $query->whereKey($request->user()->branch_id);
        }

        if (Schema::hasColumn($table, 'branch_id') && ! $request->user()->isSuperAdmin()) {
            $query->where('branch_id', $request->user()->branch_id);
        }

        if ($request->filled('branch_id') && Schema::hasColumn($table, 'branch_id')) {
            $query->where('branch_id', $request->integer('branch_id'));
        }

        if ($request->filled('status') && Schema::hasColumn($table, 'status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('search')) {
            $search = '%'.$request->string('search')->toString().'%';
            $query->where(function (Builder $inner) use ($config, $search, $table) {
                foreach ($config['fields'] as $field) {
                    if (Schema::hasColumn($table, $field)) {
                        $inner->orWhere($field, 'like', $search);
                    }
                }
            });
        }

        return $query;
    }

    private function formatRow($row, array $fields): array
    {
        $data = ['id' => $row->id];

        foreach ($fields as $field) {
            $value = $row->{$field} ?? null;

            if ($value instanceof \Carbon\CarbonInterface) {
                $value = $value->format('M d, Y');
            }

            if ($field === 'amount' && is_numeric($value)) {
                $value = 'PHP '.number_format((float) $value, 2);
            }

            $data[$field] = $value;
        }

        $data['created_at'] = optional($row->created_at)->format('M d, Y');

        return $data;
    }

    private function csv(string $title, array $fields, $rows): StreamedResponse
    {
        return response()->streamDownload(function () use ($title, $fields, $rows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [config('tgnc.church_name')]);
            fputcsv($handle, [$title]);
            fputcsv($handle, ['Date Generated', now()->toDateTimeString()]);
            fputcsv($handle, []);
            fputcsv($handle, $fields);

            foreach ($rows as $row) {
                fputcsv($handle, collect($fields)->map(fn ($field) => $row[$field] ?? '')->all());
            }

            fclose($handle);
        }, str($title)->slug().'-export.csv');
    }
}

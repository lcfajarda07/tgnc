<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }} Export</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #111827; font-size: 12px; }
        .header { border-bottom: 3px solid #0B3D91; padding-bottom: 12px; margin-bottom: 18px; }
        .church { font-size: 18px; font-weight: 700; color: #0B3D91; }
        .meta { color: #6b7280; margin-top: 4px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #0B3D91; color: #fff; text-align: left; padding: 8px; }
        td { border-bottom: 1px solid #e5e7eb; padding: 8px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="church">{{ config('tgnc.church_name') }}</div>
        <div>{{ $title }}</div>
        <div class="meta">Generated {{ now()->format('M d, Y h:i A') }} by {{ $generatedBy }}</div>
    </div>
    <table>
        <thead>
            <tr>
                @foreach ($fields as $field)
                    <th>{{ str($field)->headline() }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $row)
                <tr>
                    @foreach ($fields as $field)
                        <td>{{ $row[$field] ?? '' }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

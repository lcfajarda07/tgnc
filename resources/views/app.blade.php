<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="The Good News of Christ Global Ministries church website and management system.">
    <title inertia>{{ config('app.name', 'TGNC') }}</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg?v=faithful">
    <link rel="alternate icon" type="image/png" href="/favicon.png?v=clean">
    <link rel="apple-touch-icon" href="/favicon.png?v=clean">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    @inertiaHead
</head>
<body>
    @inertia
</body>
</html>

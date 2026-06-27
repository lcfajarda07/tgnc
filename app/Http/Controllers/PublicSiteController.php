<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\ChurchEvent;
use App\Models\GalleryItem;
use App\Models\Ministry;
use App\Models\Sermon;
use Inertia\Inertia;
use Inertia\Response;

class PublicSiteController extends Controller
{
    public function home(): Response
    {
        return Inertia::render('Home', [
            'church' => [
                'name' => config('tgnc.church_name'),
                'tagline' => config('tgnc.tagline'),
                'logo' => config('tgnc.logo_path'),
            ],
            'branches' => Branch::query()->where('status', 'active')->orderBy('id')->get(),
            'ministries' => Ministry::query()->where('status', 'active')->orderBy('sort_order')->get(),
            'sermons' => Sermon::query()->where('status', 'published')->latest('preached_at')->take(3)->get(),
            'events' => ChurchEvent::query()->where('status', 'published')->where('starts_at', '>=', now()->subDay())->orderBy('starts_at')->take(4)->get(),
            'gallery' => GalleryItem::query()->where('status', 'published')->latest('taken_at')->take(8)->get(),
        ]);
    }
}

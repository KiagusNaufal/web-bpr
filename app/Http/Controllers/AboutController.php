<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Media;
use App\Models\OrganizationalStructure;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function __invoke(): View
    {
        return view('pages.about', [
            'structures' => OrganizationalStructure::orderBy('sort_order')->get()->groupBy('group'),
            'branches' => Branch::where('is_active', true)->orderBy('sort_order')->get(),
            'gallery' => Media::whereIn('collection', ['office', 'activity', 'gallery'])->orderBy('sort_order')->get(),
        ]);
    }
}

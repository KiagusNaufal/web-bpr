<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Media;
use App\Models\OrganizationalStructure;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function __invoke(Request $request): View
    {
        $validSections = ['profil', 'sejarah', 'visi-misi', 'struktur-organisasi', 'penghargaan', 'galeri', 'karir', 'kantor'];
        $activeSection = (string) $request->query('bagian', 'profil');
        if (! in_array($activeSection, $validSections, true)) {
            $activeSection = 'profil';
        }

        return view('pages.about', [
            'activeSection' => $activeSection,
            'orgChart' => Media::where('collection', 'org_chart')->latest('id')->first(),
            'awards' => Media::where('collection', 'award')->orderBy('sort_order')->get(),
            'gallery' => Media::whereIn('collection', ['gallery', 'office', 'activity'])->orderBy('sort_order')->get(),
            'careers' => Media::where('collection', 'career')->orderBy('sort_order')->get(),
            'structures' => OrganizationalStructure::orderBy('sort_order')->get()->groupBy('group'),
            'branches' => Branch::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }
}

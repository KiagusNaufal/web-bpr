<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PublishStatus;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\CompanyProfile;
use App\Models\Media;
use App\Models\OrganizationalStructure;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('admin.profile.edit', [
            'profile' => CompanyProfile::current(),
            'orgChart' => Media::where('collection', 'org_chart')->latest('id')->first(),
            'awards' => Media::where('collection', 'award')->orderBy('sort_order')->get(),
            'structures' => OrganizationalStructure::orderBy('group')->orderBy('sort_order')->get(),
            'branches' => Branch::orderBy('sort_order')->get(),
            'testimonials' => Testimonial::orderBy('sort_order')->get(),
            'banners' => Media::whereIn('collection', ['banner', 'promo'])->orderBy('collection')->orderBy('sort_order')->get(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:140'],
            'tagline' => ['nullable', 'string', 'max:220'],
            'about' => ['nullable', 'string'],
            'history' => ['nullable', 'string'],
            'vision' => ['nullable', 'string'],
            'missions_text' => ['nullable', 'string'],
            'license_info' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:140'],
            'whatsapp' => ['nullable', 'string', 'max:25'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'tiktok_url' => ['nullable', 'url', 'max:255'],
            'operating_hours' => ['nullable', 'string', 'max:140'],
            'maps_embed_url' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'hero_image' => ['nullable', 'image', 'max:4096'],
        ]);

        $profile = CompanyProfile::current();

        $missions = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) ($validated['missions_text'] ?? '')))));

        $rawMap = trim((string) ($validated['maps_embed_url'] ?? ''));
        if ($rawMap !== '' && preg_match('/src=["\']([^"\']+)["\']/i', $rawMap, $matches)) {
            $rawMap = html_entity_decode($matches[1], ENT_QUOTES | ENT_HTML5);
        }

        $data = [
            'name' => $validated['name'],
            'tagline' => $validated['tagline'] ?? null,
            'about' => $validated['about'] ?? null,
            'history' => $validated['history'] ?? null,
            'vision' => $validated['vision'] ?? null,
            'missions' => $missions,
            'license_info' => $validated['license_info'] ?? null,
            'address' => $validated['address'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'whatsapp' => $validated['whatsapp'] ?? null,
            'facebook_url' => $validated['facebook_url'] ?? null,
            'instagram_url' => $validated['instagram_url'] ?? null,
            'tiktok_url' => $validated['tiktok_url'] ?? null,
            'operating_hours' => $validated['operating_hours'] ?? null,
            'maps_embed_url' => $rawMap !== '' ? $rawMap : null,
        ];

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('profile', 'public');
        }

        if ($request->hasFile('hero_image')) {
            $data['hero_image_path'] = $request->file('hero_image')->store('profile', 'public');
        }

        CompanyProfile::query()->updateOrCreate(['id' => $profile->id ?: 1], $data);

        return redirect()->route('admin.profile.edit')->with('success', 'Profil perusahaan berhasil diperbarui.');
    }

    public function storeStructure(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'position' => ['required', 'string', 'max:120'],
            'group' => ['required', 'in:komisaris,direksi,pejabat'],
            'bio' => ['nullable', 'string', 'max:500'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $photoPath = $request->hasFile('photo')
            ? $request->file('photo')->store('structures', 'public')
            : null;

        OrganizationalStructure::create([
            'name' => $validated['name'],
            'position' => $validated['position'],
            'group' => $validated['group'],
            'bio' => $validated['bio'] ?? null,
            'photo_path' => $photoPath,
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
        ]);

        return redirect()->to(route('admin.profile.edit').'#pengurus')->with('success', 'Data pengurus berhasil ditambahkan.');
    }

    public function destroyStructure(OrganizationalStructure $structure): RedirectResponse
    {
        $structure->delete();

        return redirect()->to(route('admin.profile.edit').'#pengurus')->with('success', 'Data pengurus berhasil dihapus.');
    }

    public function storeBranch(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'type' => ['required', 'in:pusat,cabang,kas'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'operating_hours' => ['nullable', 'string', 'max:120'],
            'maps_url' => ['nullable', 'url', 'max:500'],
        ]);

        Branch::create($validated + ['is_active' => true, 'sort_order' => Branch::count() + 1]);

        return redirect()->route('admin.profile.edit', ['tab' => 'kantor'])->with('success', 'Data kantor berhasil ditambahkan.');
    }

    public function destroyBranch(Branch $branch): RedirectResponse
    {
        $branch->delete();

        return redirect()->route('admin.profile.edit', ['tab' => 'kantor'])->with('success', 'Data kantor berhasil dihapus.');
    }

    public function storeTestimonial(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'role' => ['nullable', 'string', 'max:120'],
            'quote' => ['required', 'string', 'max:600'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'status' => ['required', Rule::enum(PublishStatus::class)],
        ]);

        $photoPath = $request->hasFile('photo')
            ? $request->file('photo')->store('testimonials', 'public')
            : null;

        Testimonial::create([
            'name' => $validated['name'],
            'role' => $validated['role'] ?? null,
            'quote' => $validated['quote'],
            'photo_path' => $photoPath,
            'status' => $validated['status'],
            'sort_order' => Testimonial::count() + 1,
        ]);

        return redirect()->route('admin.profile.edit', ['tab' => 'testimoni'])->with('success', 'Testimoni nasabah berhasil ditambahkan.');
    }

    public function destroyTestimonial(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->delete();

        return redirect()->route('admin.profile.edit', ['tab' => 'testimoni'])->with('success', 'Testimoni berhasil dihapus.');
    }

    public function storeMedia(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'collection' => ['required', 'in:banner,promo,org_chart,award'],
            'title' => ['required', 'string', 'max:160'],
            'caption' => ['nullable', 'string', 'max:255'],
            'link_url' => ['nullable', 'string', 'max:255'],
            'link_label' => ['nullable', 'string', 'max:60'],
            'image' => ['required', 'image', 'max:6144'],
        ]);

        $file = $request->file('image');
        $path = $file->store('banners', 'public');

        if ($validated['collection'] === 'org_chart') {
            Media::where('collection', 'org_chart')->delete();
        }

        Media::create([
            'collection' => $validated['collection'],
            'title' => $validated['title'],
            'caption' => $validated['caption'] ?? null,
            'link_url' => $validated['link_url'] ?? null,
            'link_label' => $validated['link_label'] ?? null,
            'path' => $path,
            'mime_type' => $file->getMimeType() ?: 'image/jpeg',
            'size' => $file->getSize() ?: 0,
            'sort_order' => Media::where('collection', $validated['collection'])->count() + 1,
            'uploaded_by' => $request->user()?->id,
        ]);

        $tab = match ($validated['collection']) {
            'org_chart' => 'pengurus',
            'award' => 'penghargaan',
            default => 'media',
        };

        return redirect()->route('admin.profile.edit', ['tab' => $tab])->with('success', 'Gambar berhasil disimpan.');
    }

    public function destroyMedia(Media $media): RedirectResponse
    {
        $tab = $media->collection === 'award' ? 'penghargaan' : 'media';
        $media->delete();

        return redirect()->route('admin.profile.edit', ['tab' => $tab])->with('success', 'Media berhasil dihapus.');
    }
}

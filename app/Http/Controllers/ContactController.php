<?php

namespace App\Http\Controllers;

use App\Enums\MessageStatus;
use App\Models\Branch;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(Request $request): View
    {
        return view('pages.contact', [
            'branches' => Branch::where('is_active', true)->orderBy('sort_order')->get(),
            'prefillSubject' => trim((string) $request->query('subjek', '')),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'phone' => ['nullable', 'string', 'max:30'],
            'subject' => ['required', 'string', 'max:160'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
            'website' => ['nullable', 'max:0'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'subject.required' => 'Subjek pesan wajib diisi.',
            'message.required' => 'Isi pesan wajib diisi.',
            'message.min' => 'Isi pesan minimal 10 karakter.',
        ]);

        ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => MessageStatus::New,
            'ip_address' => $request->ip(),
        ]);

        return redirect()
            ->route('contact')
            ->with('success', 'Terima kasih, pesan Anda telah kami terima. Petugas kami akan menindaklanjuti melalui telepon, WhatsApp, atau email.');
    }
}

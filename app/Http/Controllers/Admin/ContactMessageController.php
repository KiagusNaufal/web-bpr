<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(Request $request): View
    {
        $status = MessageStatus::tryFrom((string) $request->query('status'));
        $search = trim((string) $request->query('q'));

        $messages = ContactMessage::query()
            ->when($status, fn ($q) => $q->where('status', $status->value))
            ->when($search !== '', fn ($q) => $q->where(function ($sub) use ($search) {
                $sub->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            }))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.messages.index', [
            'messages' => $messages,
            'activeStatus' => $status,
            'statuses' => MessageStatus::cases(),
            'search' => $search,
        ]);
    }

    public function show(ContactMessage $message): View
    {
        if ($message->status === MessageStatus::New) {
            $message->update([
                'status' => MessageStatus::Read,
                'read_at' => now(),
            ]);
        }

        return view('admin.messages.show', [
            'message' => $message,
            'statuses' => MessageStatus::cases(),
        ]);
    }

    public function updateStatus(Request $request, ContactMessage $message): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::enum(MessageStatus::class)],
        ]);

        $message->update([
            'status' => $validated['status'],
            'read_at' => $message->read_at ?? now(),
        ]);

        return back()->with('success', 'Status pesan berhasil diperbarui.');
    }

    public function destroy(ContactMessage $message): RedirectResponse
    {
        $message->delete();

        return redirect()->route('admin.messages.index')->with('success', 'Pesan kontak berhasil dihapus.');
    }
}

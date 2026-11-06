@if (session('success') || session('error'))
    <div class="border-b {{ session('error') ? 'border-red-200 bg-red-50 text-red-800' : 'border-brand/30 bg-soft text-brand-deep' }}" role="status">
        <div class="container-page py-3 text-sm font-medium">{{ session('success') ?? session('error') }}</div>
    </div>
@endif

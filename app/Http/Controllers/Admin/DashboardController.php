<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ContactMessage;
use App\Models\FinancialReport;
use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'products' => Product::count(),
                'articles' => Article::count(),
                'reports' => FinancialReport::count(),
                'unread_messages' => ContactMessage::where('status', MessageStatus::New->value)->count(),
                'testimonials' => Testimonial::count(),
            ],
            'recentMessages' => ContactMessage::latest()->take(5)->get(),
            'recentArticles' => Article::with('category')->latest()->take(5)->get(),
        ]);
    }
}

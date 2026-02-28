<?php

namespace App\Http\Controllers;

use App\Models\Leader;
use Illuminate\View\View;

class SiteLeadersController extends Controller
{
    public function index(): View
    {
        $leaders = Leader::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('site.leaders', [
            'leaders' => $leaders,
        ]);
    }
}


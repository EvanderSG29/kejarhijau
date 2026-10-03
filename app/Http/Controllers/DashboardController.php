<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Admin diarahkan ke dashboard admin, member ke dashboard member.
     */
    public function index(Request $request): View|RedirectResponse
    {
        if ($request->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return view('dashboard');
    }
}

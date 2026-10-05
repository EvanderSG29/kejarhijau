<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAksesCrud
{
    /**
     * Member hanya boleh mengakses CRUD jika status_akses = true.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || (! $user->isAdmin() && ! $user->status_akses)) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Akses CRUD Anda belum diaktifkan oleh admin.');
        }

        return $next($request);
    }
}

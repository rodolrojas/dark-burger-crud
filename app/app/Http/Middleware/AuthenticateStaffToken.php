<?php

namespace App\Http\Middleware;

use App\Models\StaffAccessToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateStaffToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $plainToken = $request->bearerToken();

        if (! $plainToken) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $accessToken = StaffAccessToken::query()
            ->with('user')
            ->where('token_hash', hash('sha256', $plainToken))
            ->first();

        if (! $accessToken || ! $accessToken->user || ! $accessToken->user->active) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        if ($accessToken->expires_at && $accessToken->expires_at->isPast()) {
            return response()->json(['message' => 'Token expired.'], 401);
        }

        $accessToken->forceFill(['last_used_at' => now()])->save();
        $request->setUserResolver(fn () => $accessToken->user);

        return $next($request);
    }
}

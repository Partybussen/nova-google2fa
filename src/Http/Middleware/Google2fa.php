<?php

namespace Project383\Google2fa\Http\Middleware;

use Closure;
use Inertia\Inertia;
use Project383\Google2fa\Google2FAAuthenticator;
use PragmaRX\Google2FA\Google2FA as G2fa;
use PragmaRX\Recovery\Recovery;

/**
 * Class Google2fa
 * @package Project383\Google2fa\Http\Middleware
 */
class Google2fa
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     * @throws \PragmaRX\Google2FA\Exceptions\InsecureCallException
     */
    public function handle($request, Closure $next)
    {
        if (!config('383project2fa.enabled')) {
            return $next($request);
        }

        // continue when user is not required to have 2fa
        if (config('383project2fa.requires_2fa_attribute') &&
            !auth()->user()->{config('383project2fa.requires_2fa_attribute')}) {
            return $next($request);
        }

        $authenticator = app(Google2FAAuthenticator::class)->boot($request);

        $user2faEnabled = auth()->user()->user2fa && auth()->user()->user2fa->google2fa_enable;
        $user2faAuthenticated = $authenticator->isAuthenticated() && $user2faEnabled;

        $paths2fa = [
            '2fa/recover',
            '2fa/confirm',
            '2fa/authenticate',
            '2fa/register'
        ];

        $pathsUnregisteredOnly = [
            '2fa/register',
            '2fa/confirm'
        ];

        if ($user2faAuthenticated && in_array($request->path(), $paths2fa)) {
            return Inertia::location(config('nova.path'));
        }

        // redirect user with registered 2fa to authenticate page
        if ($user2faEnabled && in_array($request->path(), $pathsUnregisteredOnly)) {
            return Inertia::location('/2fa/authenticate');
        }

        // redirect user to register 2fa when it should have 2fa, but doesn't
        if (!$user2faEnabled && !in_array($request->path(), $pathsUnregisteredOnly)) {
            return Inertia::location('/2fa/register');
        }

        // allow 2fa management urls
        if (in_array($request->path(), $paths2fa)) {
            return $next($request);
        }

        if (auth()->guest() || $user2faAuthenticated) {
            return $next($request);
        }

        // redirect user to authentication of 2fa code
        return Inertia::location('/2fa/authenticate');
    }
}
<?php

namespace PowerDialer\Dialer;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class DialerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/dialer.php', 'dialer');

        // Path-repository installs don't always process the files[] autoload entry,
        // so we require the helpers explicitly to guarantee dialer_route() is available.
        if (! function_exists('dialer_route')) {
            require_once __DIR__ . '/helpers.php';
        }

        $this->app->singleton(\PowerDialer\Dialer\Services\TcpaService::class);
    }

    public function boot(): void
    {
        // Config
        $this->publishes([
            __DIR__ . '/../config/dialer.php' => config_path('dialer.php'),
        ], 'dialer-config');

        // Migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'dialer-migrations');

        // Views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'dialer');
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/dialer'),
        ], 'dialer-views');

        // Middleware alias
        $router = $this->app['router'];
        if (! array_key_exists('twilio.verify', $router->getMiddleware())) {
            $router->aliasMiddleware(
                'twilio.verify',
                \PowerDialer\Dialer\Http\Middleware\ValidateTwilioSignature::class
            );
        }

        // Routes
        $this->loadRoutes();

        // Gates (skip if host app already defines them)
        if (config('dialer.define_gates', true)) {
            Gate::define('dialer_access', function ($user) {
                if (method_exists($user, 'hasPermissionTo')) {
                    return $user->hasPermissionTo('dialer_access');
                }
                // Fallback: all authenticated users have access
                return true;
            });
            Gate::define('dialer_supervisor', function ($user) {
                if (method_exists($user, 'hasPermissionTo')) {
                    return $user->hasPermissionTo('dialer_supervisor');
                }
                // Fallback: check for is_admin or role column
                return $user->is_admin ?? $user->role === 'supervisor' ?? false;
            });
        }
    }

    private function loadRoutes(): void
    {
        $prefix = config('dialer.route_prefix', '');
        $nameAs = config('dialer.route_name_prefix', '');
        $authMw = config('dialer.auth_middleware', ['auth']);

        $webRoute = Route::middleware(array_merge(['web'], $authMw));

        if ($prefix !== '') {
            $webRoute = $webRoute->prefix($prefix);
        }

        if ($nameAs !== '') {
            $webRoute = $webRoute->name($nameAs);
        }

        // Admin UI routes (auth-guarded, web middleware)
        $webRoute->group(__DIR__ . '/../routes/web.php');

        // Twilio webhook routes — intentionally NO web middleware (no CSRF, no session)
        // Only twilio.verify (signature validation) is applied.
        Route::middleware(['twilio.verify'])
            ->prefix('webhooks/twilio')
            ->name('webhooks.twilio.')
            ->group(__DIR__ . '/../routes/webhooks.php');
    }
}

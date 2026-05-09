<?php

if (! function_exists('dialer_route')) {
    /**
     * Generate a URL to a dialer package route using the configured name prefix.
     *
     * @param  string  $name    Route name without the prefix, e.g. 'index', 'softphone', 'groups.index'
     * @param  mixed   $params
     * @return string
     */
    function dialer_route(string $name, $params = []): string
    {
        $prefix = config('dialer.route_name_prefix', '');
        return route($prefix . 'dialer.' . $name, $params);
    }
}

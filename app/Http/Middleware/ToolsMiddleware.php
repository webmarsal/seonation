<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToolsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // If Guest tools are not enabled and the user is Guest
        if (!config('settings.tools_guest') && Auth::guest()) {
            return redirect()->route('login');
        }

        // If the Google Custom Search API is not enabled
        if (!config('settings.gcs')) {
            // Update the Tools list
            config(['tools' => array_filter(config('tools'), function ($item) {
                if (!in_array($item['route'], ['tools.serp_checker', 'tools.indexed_pages_checker'])) {
                    return $item;
                }
                return false;
            })]);
        }

        // If the KeywordsEverywhere API is not enabled
        if (!config('settings.ke')) {
            // Update the Tools list
            config(['tools' => array_filter(config('tools'), function ($item) {
                if ($item['route'] !== 'tools.keyword_research') {
                    return $item;
                }
                return false;
            })]);
        }

        return $next($request);
    }
}

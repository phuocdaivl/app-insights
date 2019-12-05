<?php
namespace DaiDP\AppInsights\Providers;

use DaiDP\AppInsights\TelemetryClient;
use Illuminate\Support\ServiceProvider;

/**
 * Class AzureAppInsightsProvider
 * @package DaiDP\AppInsights\Providers
 * @author DaiDP
 * @since Dec, 2019
 * @see https://packagist.org/packages/microsoft/application-insights
 */
class AzureAppInsightsProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $path = realpath(__DIR__.'/../../config/config.php');

        $this->publishes([$path => config_path('app-insights.php')], 'config');
        $this->mergeConfigFrom($path, 'app-insights');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('DaiDP\AppInsights\TelemetryClient', function($app) {
            $telemetry = new TelemetryClient();
            $context   = $telemetry->getContext();

            // Necessary
            $context->setInstrumentationKey($this->config('instrumentation_key'));

            // Optional
            $context->getApplicationContext()->setVer(config('app.name'));
            $context->getLocationContext()->setIp(request()->getClientIp());

            // Check disable tracking
            if ($this->config('disable_tracking')) {
                $telemetry->disableTracking();
            }

            $telemetry->displayError($this->config('http_errors'));
            return $telemetry;
        });
    }

    /**
     * Helper to get the config values.
     *
     * @param  string  $key
     * @param  string  $default
     *
     * @return mixed
     */
    protected function config($key, $default = null)
    {
        return config("app-insights.$key", $default);
    }
}
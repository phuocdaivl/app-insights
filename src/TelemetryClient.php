<?php
namespace DaiDP\AppInsights;

use ApplicationInsights\Telemetry_Client;

/**
 * Class TelemetryClient
 * @package DaiDP\AppInsights
 * @author DaiDP
 * @since Dec, 2019
 */
class TelemetryClient extends Telemetry_Client
{
    protected $trackingAuth = true;
    protected $disableTracking = false;

    /**
     * Tắt check authen
     */
    public function disableAuth()
    {
        $this->trackingAuth = false;
    }

    /**
     * Disable send data to Application Insights
     */
    public function disableTracking()
    {
        $this->disableTracking = true;
    }

    /**
     * Flushes the underlying Telemetry_Channel queue.
     * @param array $options - Guzzle client option overrides
     * @param bool  $sendAsync - Send the request asynchronously
     * @return \GuzzleHttp\Promise\PromiseInterface|\Psr\Http\Message\ResponseInterface|null|WP_Error
     */
    public function flush($options = array(), $sendAsync = false)
    {
        // Tắt tracking
        if ($this->disableTracking) {
            return null;
        }

        if ($this->trackingAuth) {
            $context   = $this->getContext();
            try {
                $context->getUserContext()->setId(auth()->check() ? auth()->id() : null);
            }
            catch (\Exception $ex) {}
        }

        return parent::flush($options = array(), $sendAsync = false);
    }
}
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

    /**
     * Tắt check authen
     */
    public function disableAuth()
    {
        $this->trackingAuth = false;
    }

    /**
     * Flushes the underlying Telemetry_Channel queue.
     * @param array $options - Guzzle client option overrides
     * @param bool  $sendAsync - Send the request asynchronously
     * @return \GuzzleHttp\Promise\PromiseInterface|\Psr\Http\Message\ResponseInterface|null|WP_Error
     */
    public function flush($options = array(), $sendAsync = false)
    {
        if ($this->trackingAuth) {
            $context   = $this->getContext();
            $context->getUserContext()->setId(auth()->check() ? auth()->id() : null);
        }

        return parent::flush($options = array(), $sendAsync = false);
    }
}
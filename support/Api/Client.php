<?php

namespace Support\Api;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

use Support\Api\Request as ApiRequest;
use Support\Api\Response as ApiResponse;

class Client
{
    protected $baseUri;

    /**
     * Constructor
     */
    public function __construct($baseUri = null)
    {
        $this->baseUri = $baseUri;
        $this->timeout = config('api.defaults.timeout');
        $this->headers = config('api.defaults.headers')->toArray();;
    }

    /**
     * Send request to API server and return response
     *
     * @param GuzzleRequest $request
     * @return array
     */
    public function send(ApiRequest $request)
    {
        try {
            if (config('app.debug')) {
                $this->logger()->info(sprintf('%s%s %s', $this->baseUri, $request->uri(), json_encode($request->formParams())));
            }

            $options = [
                'timeout' => $this->timeout,
                'headers' => $this->headers ?: [],
                'json' => $request->formParams()
            ];

            if ($request->sink()) {
                $options['sink'] = $request->sink();
            }

            $response = $this->getClient()->request(
                $request->method(),
                $request->uri(),
                $options
            );

            $responseBody = json_decode($response->getBody(), true) ?: [];

            if ($request->sink()) {
                $responseBody['temporary_file'] = $request->sink();
            }

            return new ApiResponse(
                true,
                $response->getStatusCode() ?: 0,
                $responseBody
            );
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return new ApiResponse(
                    false,
                    $e->getResponse()->getStatusCode(),
                    json_decode($e->getResponse()->getBody(), true) ?: []
                );
            } else {
                if (config('app.debug')) {
                    $this->logger()->error(Psr7\str($e->getRequest()));
                    $this->logger()->error($e->getMessage());
                }

                return new ApiResponse(false, 500, []);
            }
        }
    }

    /**
     * Build client for requesting server
     *
     * @return GuzzleClient
     */
    protected function getClient()
    {
        return new GuzzleClient([
            'base_uri' => $this->baseUri,
            'timeout'  => $this->timeout,
            'headers' => $this->headers,
        ]);
    }

    protected function logger()
    {
        return \Phalcon\Di::getDefault()->getShared('log');
    }
}

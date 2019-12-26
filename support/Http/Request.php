<?php

namespace Support\Http;

use Phalcon\Http\Request as PhalconHttpRequest;
use Support\Http\Concerns\InteractsWithInput;
use Support\Http\Concerns\InteractsWithValidtion;
use Support\Http\Concerns\InteractsWithFile;

/**
 * Improves base phalcon request with more utilities
 */
class Request extends PhalconHttpRequest
{
    use InteractsWithInput, InteractsWithValidtion, InteractsWithFile;

    /**
     * Check if current request is allowed
     *
     * @return bool
     */
    public function authorized()
    {
        return true;
    }
}

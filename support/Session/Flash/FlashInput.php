<?php

namespace Support\Session\Flash;

use Phalcon\Mvc\User\Component;
use Support\Session\Flash\Concerns\FlashData;

class FlashInput extends Component
{
    use FlashData;

    /**
     * Get session name
     *
     * @return string
     */
    protected function sessionName()
    {
        return '_input';
    }
}

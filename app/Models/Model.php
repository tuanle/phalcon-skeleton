<?php

namespace App\Models;

use Phalcon\Mvc\Model as PhalconMvcModel;

/**
 * Base model for application
 */
class Model extends PhalconMvcModel
{
    public function initialize()
    {
        $this->useDynamicUpdate(true);

        $this->setSource($this->table);
    }
}

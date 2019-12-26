<?php
/*
|--------------------------------------------------------------------------
| Define base directory's paths
|--------------------------------------------------------------------------
*/
define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/bootstrap/abstract.php';
require_once BASE_PATH . '/bootstrap/application.php';

(new Application())->run();

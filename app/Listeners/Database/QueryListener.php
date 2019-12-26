<?php

namespace App\Listeners\Database;

use Phalcon\Db\Profiler;
use Phalcon\Events\Event;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\File as FileLogger;

use Phalcon\Mvc\Model\Query;

class QueryListener
{
    /**
     * @var \Phalcon\Db\Profiler
     */
    protected $profiler;

    /**
     * @var \Phalcon\Logger
     */
    protected $sqlLogger;

    /**
     * @var \Phalcon\Logger
     */
    protected $sqlSlowLogger;

    /**
     * Creates the profiler and starts the logging
     */
    public function __construct()
    {
        $this->profiler      = new Profiler();
        $this->sqlLogger     = new FileLogger(config('app.sql_log_path'));
        $this->sqlSlowLogger = new FileLogger(config('app.sql_slow_log_path'));
    }

    /**
     * This is executed if the event triggered is 'beforeQuery'
     */
    public function beforeQuery(Event $event, $connection)
    {
        $this->profiler->startProfile(
            $connection->getSQLStatement(),
            $connection->getSqlVariables()
        );
    }

    /**
     * This is executed if the event triggered is 'afterQuery'
     */
    public function afterQuery(Event $event, $connection)
    {
        // Stop profiler
        $this->profiler->stopProfile();

        // Get last profile
        $profile = $this->profiler->getLastProfile();

        // Write log
        $host           = $this->getHostId($connection);
        $elapsedSeconds = $profile->getTotalElapsedSeconds();
        $statement      = $profile->getSQLStatement();
        $variables      = $profile->getSqlVariables();
        $rawSql         = $this->getRawSql($statement, $variables);

        $this->sqlLogger->log($this->logMessage($host, $rawSql, $variables, $elapsedSeconds), Logger::DEBUG);

        if ($elapsedSeconds > 1) { // Slow query
            $this->sqlSlowLogger->log($this->logMessage($host, $rawSql, $variables, $elapsedSeconds), Logger::DEBUG);
        }
    }

    /**
     * Get profiler
     *
     * @return Profiler
     */
    public function getProfiler()
    {
        return $this->profiler;
    }

    /**
     * Build log message from parameters
     *
     * @param string $host
     * @param string $statement
     * @param array $variables
     * @param float $elapsedSeconds
     * @return string
     */
    protected function logMessage($host, $statement, $variables, $elapsedSeconds)
    {
        $log = PHP_EOL
            . 'CONNECTION : ' . '[' . $host . ']' . PHP_EOL
            . 'STATEMENT  : ' . $statement . PHP_EOL
            . 'PARAMETER  : ' . print_r($variables, true)
            . 'ELAPSED    : ' . $elapsedSeconds . ' (seconds)' . PHP_EOL;

        return $log;
    }

    /**
     * Get host indentifier from connection
     *
     * @param \Phalcon\Db\Adapter
     */
    protected function getHostId($connection)
    {
        $descriptor = $connection->getDescriptor();
        return sprintf('%s:%s', $descriptor['driver'] ?? 'unknown', $descriptor['host'] ?? 'unknown');
    }

    /**
     * Simple build raw sql from statement and variables
     * Please notice, my function just "try" to make human-readable SQL,
     * it should not considered as a real SQL builder
     *
     * @param $statement
     * @param $variables
     * @return string
     */
    protected function getRawSql($statement, $variables)
    {
        if (is_array($variables) && !empty($variables)) {
            try {
                $keys = [];
                $values = [];

                foreach ($variables as $key => $value) {
                    if (is_string($key)) {
                        if (is_array($value)) {
                            foreach ($value as $valueKey => $valueValue) {
                                $keys[] = '/:' . ltrim($key . $valueKey, ':') .'/';
                            }
                        } else {
                            $keys[] = '/:' . ltrim($key, ':') .'/';
                        }
                    } else {
                        $keys[] = '/[\?]/';
                    }

                    if (is_null($value)) {
                        $values[] = 'NULL';
                    } elseif (is_numeric($value)) {
                        $values[] = $value;
                    } elseif (is_array($value)) {
                        foreach ($value as $valueItem) {
                            $values[] = '"'. addslashes($valueItem) . '"';
                        }
                    } elseif (method_exists($value, 'getValue')) {
                        $values[] = $value->getValue();
                    } else {
                        $value = (string) $value;
                        $values[] = '"'. addslashes($value) . '"';
                    }
                }

                $statement = preg_replace($keys, $values, $statement, 1) . ';';
            } catch (\Exception $e) {
            }

            return $statement;
        }

        return $statement;
    }
}

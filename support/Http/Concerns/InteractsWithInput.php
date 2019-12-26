<?php

namespace Support\Http\Concerns;

use Phalcon\Filter;
use Phalcon\Http\Request\File;

trait InteractsWithInput
{
    protected $flashExcepts = [
        '_url',
        '_csrf',
    ];

    /**
     * Get all inputs with sanitizing
     *
     * @param string $filter
     * @return array
     */
    public function all(string $filter = null)
    {
        $inputs = $this->get(null, $filter === false ? Filter::FILTER_STRING : $filter);
        $files = $this->files();

        return array_merge($inputs, $files);
    }

    /**
     * Get list of particular inputs with sanitizing
     *
     * @param array $keys
     * @return array
     */
    public function only(array $inputs = [])
    {
        $values = [];

        foreach ($inputs as $input) {
            if (is_array($input)) {
                list($key, $filter) = $input;
            } else {
                list($key, $filter) = [$input, Filter::FILTER_STRING];
            }

            $values[$input] = $this->get($key, $filter, null);
        }

        return $values;
    }

    /**
     * Get list of inputs (excepts some particular inputs) with default sanitizing
     *
     * @param array $keys
     * @return array
     */
    public function excepts(array $inputs = [])
    {
        $values = $this->all();

        foreach ($values as $key => $value) {
            if (in_array($key, $inputs)) {
                unset($values[$key]);
            }
        }

        return $values;
    }

    /**
     * Get all old inputs
     *
     * @return array
     */
    public function oldInputs()
    {
        return $this->getDI()->get('flashInput')->all();
    }

    /**
     * Flash input values to next response
     *
     * @param array $inputs
     * @return void
     */
    public function flashInputs($inputs = [])
    {
        $inputs = $inputs ?: $this->excepts($this->flashExcepts);

        foreach ($inputs as $key => $input) {
            if ($input instanceof File) {
                // Upload temporarily before flash
                $inputs[$key] = $this->uploadTemporarily($input);
            }
        }

        $this->getDI()->get('flashInput')->flash($inputs);
    }
}

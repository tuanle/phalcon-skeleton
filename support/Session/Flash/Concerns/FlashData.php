<?php

namespace Support\Session\Flash\Concerns;

trait FlashData
{
    protected $data;

    /**
     * Grows up the session data
     *
     * @return void
     */
    public function ageFlashData()
    {
        $flashData = $this->session()->get($this->sessionName());

        $flashData['old'] = $flashData['new'] ?: [];
        $flashData['new'] = [];

        $this->session()->set($this->sessionName(), $flashData);
    }

    /**
     * Get the data
     *
     * @return array
     */
    public function all()
    {
        if (!isset($this->data) || is_null($this->data)) {
            $this->data = $this->session()->get($this->sessionName());
        }

        return $this->data['old'] ?? [];
    }

    /**
     * Get the paricular data with the name
     *
     * @param string $name
     * @return mixed
     */
    public function get(string $name, $default = null)
    {
        $data = $this->all();
        return $data[$name] ?? $default;
    }

    /**
     * Flash new data to session
     *
     * @param array $data
     * @return void
     */
    public function flash(array $data)
    {
        $flashData = $this->session()->get($this->sessionName());
        $flashData['new'] = $data;

        $this->session()->set($this->sessionName(), $flashData);
    }

    /**
     * Get the session service
     *
     * @return \Phalcon\Session;
     */
    protected function session()
    {
        return ($this->getDI() ?? \Phalcon\Di::getDefault())->getShared('session');
    }
}

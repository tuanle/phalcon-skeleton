<?php

namespace Support\Http\Concerns;

use Phalcon\Validation as PhalconValidation;
use Phalcon\Validation\Message\Group as MessageGroup;
use Support\Session\Flash\OldInputs;

trait InteractsWithValidtion
{
    /**
     * @var PhalconValidation
     */
    protected $validation;

    /**
     * @var array
     */
    protected $errors;

    /**
     * @var string
     */
    protected $redirectUrl;

    /**
     * Set the validation for this request
     *
     * @param PhalconValidation $validation
     * @return void
     */
    public function setValidation(PhalconValidation $validation)
    {
        $this->validation = $validation;
    }

    /**
     * Auto redirect user if the request is invalid
     *
     * @return bool
     */
    public function autoRedirect()
    {
        return true;
    }

    /**
     * Set the url that the request will be redirect to if it is not valid
     *
     * @param string $redirectUrl
     * @return void
     */
    public function setRedirectUrl(string $redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * Get the url that the request will be redirect to if it is not valid
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * Check if the request is valid or not
     * Notice that if the validation is not set, the request will be always valid
     *
     * @param void
     * @return bool
     */
    public function isValid()
    {
        if (!empty($this->validation)) {
            $messages = $this->validation->validate($this->all());

            if (count($messages)) {
                $this->errors = $this->formatValidationMessages($messages);
                return false;
            }

            return true;
        }

        return true; // This request is not need to be validated
    }

    /**
     * Flash validation errors to next response
     *
     * @param void
     * @return void
     */
    public function flashErrors()
    {
        $this->getDI()->get('flashError')->flash($this->errors);
    }

    /**
     * Re-format validation error messages to array
     *
     * @param MessageGroup $messages
     * @return array
     */
    protected function formatValidationMessages(MessageGroup $messages)
    {
        $errors = [];

        foreach ($messages as $message) {
            $field = $message->getField();

            if (!isset($formatted[$field])) {
                $errors[$field] = [];
            }

            if ($rawMessage = $message->getMessage()) {
                array_push($errors[$field], $rawMessage);
            }
        }

        return $errors;
    }
}

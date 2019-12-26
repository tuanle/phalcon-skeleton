<?php

namespace Support\Exceptions;

use Phalcon\Exception as PhalconException;

class ImageUploadException extends PhalconException
{
    /**
     * int
     */
    protected $errorCode;

    public function __construct(int $errorCode, $code = 500, $previous = null)
    {
        $this->errorCode = $errorCode;

        $message = $this->codeToMessage($errorCode);

        parent::__construct($message, $code, $previous);
    }

    /**
     * get error message from error code
     *
     * @return string
     */
    public function codeToMessage($code)
    {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
                break;

            case UPLOAD_ERR_FORM_SIZE:
                $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
                break;

            default:
                $message = "Unknown upload error";
                break;
        }

        return $message;
    }
}

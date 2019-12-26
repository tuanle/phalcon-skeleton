<?php

namespace Support\View;

use Phalcon\Mvc\User\Component;

class Helper extends Component
{
    /**
     * This method is called on any attempt to compile a function call
     */
    public function compileFunction($name, $arguments)
    {
        if (function_exists($name)) {
            return $name . '('. $arguments . ')';
        }

        if ($name === 'e') {
            return '!empty(' . $arguments . ') ? $this->escaper->escapeHtml(' . $arguments . ')' . ' : ""';
        }

        if (method_exists($this, $name)) {
            return '$this->viewHelper->' . $name . '('. $arguments . ')';
        }
    }

    /**
     * Get validation errors
     *
     * @return array
     */
    public function validation_errors()
    {
        return $this->getDI()->get('flashError')->all();
    }

    /**
     * Get validation error for a paricular input
     *
     * @return array
     */
    public function validation_error(string $input = '')
    {
        if ($error = $this->getDI()->get('flashError')->get($input)) {
            return reset($error);
        }

        return '';
    }

    /**
     * Get input's old value
     *
     * @return mixed
     */
    public function old_input(string $input = '', $default = null)
    {
        return $this->getDI()->get('flashInput')->get($input, $default);
    }

    /**
     * Get csrf token value
     *
     * @return string
     */
    public function csrf_token()
    {
        $csrf = $this->getDI()->get('security')->getSessionToken();

        if (empty($csrf)) {
            $csrf = $this->getDI()->get('security')->getToken();
        }

        return $csrf;
    }

    /**
     * Get csrf hidden field
     *
     * @return string
     */
    public function csrf_field()
    {
        return $this->getDI()->getTag()->hiddenField(['_csrf', 'value' => $this->csrf_token()]);
    }

    /**
     * Builds HTML <img/> code for CloudFront image
     *
     * @param mixed $parameters
     * @return string
     */
    public function cloud_image($parameters)
    {
        if (is_string($parameters)) {
            $params = [$parameters];
        } else if (is_array($parameters)) {
            $params = $parameters;
        } else {
            $params = [];
        }

        $src = '';
        if (isset($params['src']) && is_string($params['src'])) {
            $src = $params['src'];
        } else if (isset($params[0]) && is_string($params[0])) {
            $src = $params[0];
            unset($params[0]);
        }

        // Build CloudFront src
        $parts = parse_url($src);
        $cloudSrc = config('filesystems.images.cloud_front.host');

        if (isset($parts['path'])) {
            if (strpos($parts['path'], '/') === 0) {
                $cloudSrc .= $parts['path'];
            } else {
                $cloudSrc .= '/' . $parts['path'];
            }
        }

        if (isset($parts['query'])) {
            $cloudSrc .= '?' . $parts['query'];
        }

        if (isset($parts['fragment'])) {
            $cloudSrc .= '#' . $parts['fragment'];
        }

        // Re-update params
        $params['src'] = $cloudSrc;

        return $this->tag->image($params, false); // This image is not local image
    }
}

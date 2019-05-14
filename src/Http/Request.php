<?php

namespace Imhio\Http;

class Request
{

    public $method = 'GET';
    public $path = '/';
    public $post = [];

    public function __construct () {

        $this->method = strtoupper ($_SERVER ['REQUEST_METHOD']);
        $this->post = $_POST;

        $parsed_url = parse_url ($_SERVER ['REQUEST_URI']);
        if (isset ($parsed_url ['path']))
            $this->path = $parsed_url ['path'];
    }
}
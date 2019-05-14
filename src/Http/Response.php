<?php

namespace Imhio\Http;

class Response
{

    const HTTP_OK = 200;
    const HTTP_NOT_FOUND = 404;

    public $status_code;
    public $content;
    public $content_type;

    public function __construct (int $status_code, string $content, string $content_type) {

        $this->status_code = $status_code;
        $this->content = $content;
        $this->content_type = $content_type;
    }

    public function render ()
    {
        header_remove ();
        header ("Content-Type: {$this->content_type};charset=utf8");
        header ("Status: {$this->status_code}");
        http_response_code ($this->status_code);

        echo $this->content;
    }
}
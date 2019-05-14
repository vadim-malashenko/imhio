<?php

namespace Imhio\Http;

class Router
{

    protected $request;
    protected $routes;

    public function __construct (Request $request) {

        $this->request = $request;
    }

    public function add (array $routes = []) {

        $this->routes = $routes;
    }

    public function route () {

        foreach ($this->routes as $route)
            if ($this->request->method == $route ['method'] && $this->request->path == $route ['path'])
                return $route ['response'] ($this->request);

        throw new NotFoundException ();
    }
}
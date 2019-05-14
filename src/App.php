<?php

namespace Imhio;

use Imhio\Http\Router;
use Imhio\Http\Request;
use Imhio\Http\Response;
use Imhio\Api\Resources\Email;

class App {

    protected static function autoload ($class) {

        $namespace_length = strlen (__NAMESPACE__);

        if (strncmp (__NAMESPACE__, $class, $namespace_length) === 0) {

            $file = str_replace (['/', '\\'], DIRECTORY_SEPARATOR, SRC . substr ($class, $namespace_length)) . '.php';

            if (file_exists ($file))
                require $file;
        }
    }

    public static function start () {

        spl_autoload_register ([static::class, 'autoload']);

        $routes = [
            [
                'method' => 'GET',
                'path' => '/',
                'response' => function () {
                    return new Response (Response::HTTP_OK, file_get_contents ('app.html'), 'text/html');
                }
            ],
            [
                'method' => 'POST',
                'path' => '/email/check',
                'response' => function ($request) {
                    return new Response (Response::HTTP_OK, json_encode (Email::check ($request)), 'application/json');
                }
            ]
        ];

        $router = new Router (new Request ());
        $router->add ($routes);

        try {
            $response = $router->route ();
        }
        catch (NotFoundException $ex) {
            $response = new Response (Response::HTTP_NOT_FOUND, $ex->getMessage (), 'text/plain');
        }

        $response->render ();
    }
}
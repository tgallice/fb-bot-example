<?php

namespace Bot\Controllers;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

class HomeControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        $controllers->get('/', [$this, 'get']);

        return $controllers;
    }

    public function get()
    {
        return new Response('Bot Starter !');
    }
}

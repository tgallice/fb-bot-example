<?php

namespace Bot\Controllers;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Response;
use Tgallice\FBMessenger\WebhookRequestHandler;

class WebhookControllerProvider implements ControllerProviderInterface
{
    /**
     * @var WebhookRequestHandler
     */
    private $webhookRequestHandler;

    public function connect(Application $app)
    {
        $this->webhookRequestHandler = $app['webhook_request_handler'];

        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];

        $controllers->get('/', [$this, 'get']);
        $controllers->post('/', [$this, 'post']);


        return $controllers;
    }

    public function get()
    {
        if (!$this->webhookRequestHandler->isValidVerifyTokenRequest()) {
            return new Response(null, 400);
        }

        $challenge = $this->webhookRequestHandler->getChallenge();

        return new Response($challenge);
    }

    public function post()
    {
        if (!$this->webhookRequestHandler->isValidCallbackRequest()) {
            return new Response(null, 400);
        }
        
        $this->webhookRequestHandler->dispatchCallbackEvents();

        return new Response();
    }
}

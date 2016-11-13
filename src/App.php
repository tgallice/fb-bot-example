<?php

namespace Bot;

use Bot\Controllers\HomeControllerProvider;
use Bot\Controllers\WebhookControllerProvider;
use Bot\Listeners\CallbackEventListener;
use Silex\Application;
use Tgallice\FBMessenger\Client;
use Tgallice\FBMessenger\Messenger;
use Tgallice\FBMessenger\WebhookRequestHandler;

class App extends Application
{
    private $rootDir;

    public function __construct()
    {
        $this->rootDir = __DIR__ . '/..';
        parent::__construct();

        $this->loadConfig();

        $this['fb_messenger'] = function (Application $app) {
            $client = new Client($app['facebook_access_token']);

            return new Messenger($client);
        };

        $this['webhook_request_handler'] = function (Application $app) {
            $webhookRequestHandler = new WebhookRequestHandler($app['facebook_app_secret'], $app['facebook_verify_token']);
            $webhookRequestHandler->addEventSubscriber(new CallbackEventListener($app['fb_messenger']));

            return $webhookRequestHandler;
        };

        // Mount controllers
        $this->mount('/', new HomeControllerProvider());
        $this->mount('/webhook', new WebhookControllerProvider());
    }

    private function loadConfig()
    {
        $configFile = $this->rootDir.'/app/config.php';

        if (!file_exists($configFile)) {
            throw new \RuntimeException(sprintf('The file "%s" does not exist.', $configFile));
        }

        $config = require_once $configFile;

        foreach ($config as $key => $value) {
            $this[$key] = $value;
        }
    }
}

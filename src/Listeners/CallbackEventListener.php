<?php

namespace Bot\Listeners;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Tgallice\FBMessenger\Callback\MessageEvent;
use Tgallice\FBMessenger\Messenger;

class CallbackEventListener implements EventSubscriberInterface
{
    private $messenger;

    public function __construct(Messenger $messenger)
    {
        $this->messenger = $messenger;
    }

    public static function getSubscribedEvents()
    {
        return [
            MessageEvent::NAME => 'sendEcho',
        ];
    }

    /**
     * This method will simply send back the message receive to the sender
     *
     * @param MessageEvent $event
     */
    public function sendEcho(MessageEvent $event)
    {
        $this->messenger->sendMessage($event->getSenderId(), $event->getMessageText());
    }
}

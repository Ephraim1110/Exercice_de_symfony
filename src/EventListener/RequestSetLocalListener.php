<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
class RequestSetLocalListener
{

/**
 * @param RequestEvent $event
 * $return void
 */
public function local(RequestEvent $event):void
{
    $event->getRequest()->setLocale(\locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']));
}
}
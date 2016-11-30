<?php
namespace Demo\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Psr\Log\LoggerInterface;
use SimpleBus\Message\Bus\Middleware\MessageBusSupportingMiddleware;

abstract class AbstractRestController extends FOSRestController
{
    /**
     * @param object $command
     */
    protected function execCommand($command)
    {
        $this->getCommandBus()->handle($command);
    }

    /**
     * @return MessageBusSupportingMiddleware
     */
    private function getCommandBus()
    {
        return $this->get('command_bus');
    }

    /**
     * @return LoggerInterface
     */
    protected function getLogger()
    {
        return $this->get('logger');
    }
}

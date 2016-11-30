<?php
namespace Demo\ApiBundle\Event\Listener;

use Demo\Core\Exception\DomainException;
use FOS\RestBundle\Util\Codes;
use Demo\ApiBundle\Response\GenericResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var string
     */
    private static $logFormat = '[API] %s';

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $statusCode = Codes::HTTP_INTERNAL_SERVER_ERROR;
        $exception = $event->getException();
        $response = new JsonResponse();

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        }

        if ($exception instanceof BadRequestHttpException || $exception instanceof DomainException) {
            $statusCode = 400;
        }

        $message = $exception->getMessage();
        $response->setStatusCode($statusCode);

        if ($statusCode == Codes::HTTP_INTERNAL_SERVER_ERROR) {
            $this->logger->critical(sprintf(static::$logFormat, $exception));
            $message = 'Service Unavailable';
        } else {
            $this->logger->info(sprintf(static::$logFormat, $exception->getMessage()));
        }

        $response->setData(new GenericResponse(null, $statusCode, $message));

        $event->setResponse($response);
    }
}

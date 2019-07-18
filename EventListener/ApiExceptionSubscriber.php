<?php

namespace SoftPassio\ApiExceptionBundle\EventListener;

use SoftPassio\ApiExceptionBundle\Api\ApiProblem;
use SoftPassio\ApiExceptionBundle\Component\Factory\ResponseFactoryInterface;
use SoftPassio\ApiExceptionBundle\Exception\ApiProblemException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiExceptionSubscriber implements EventSubscriberInterface
{
    private $debug;
    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;
    private $enabled;
    private $excludedPaths;

    public function __construct($debug, ResponseFactoryInterface $responseFactory, $enabled = true, $excludedPaths = [])
    {
        $this->debug = $debug;
        $this->responseFactory = $responseFactory;
        $this->enabled = $enabled;
        $this->excludedPaths = $excludedPaths;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if ($this->enabled !== true) {
            return;
        }
        $e = $event->getException();
        $requestPath = $event->getRequest()->getPathInfo();

        $statusCode = $e instanceof HttpExceptionInterface ? $e->getStatusCode() : 500;

        if (($this->debug && $statusCode >= 500) || $this->checkExcludedPaths($requestPath) === false) {
            return;
        }

        if ($e instanceof ApiProblemException) {
            $apiProblem = $e->getApiProblem();
        } else {
            $apiProblem = new ApiProblem(
                $statusCode
            );

            if ($e instanceof HttpExceptionInterface) {
                $apiProblem->set('detail', $e->getMessage());
            }
        }

        $response = $this->responseFactory->createResponse($apiProblem);
        $event->setResponse($response);
    }

    private function checkExcludedPaths($path)
    {
        $status = true;

        if (!$this->excludedPaths || !is_array($this->excludedPaths)) {
            return $status;
        }

        foreach ($this->excludedPaths as $excludedPath) {
            if (preg_match($excludedPath, $path)) {
                $status = false;
                break;
            }
        }
        return $status;
    }
}

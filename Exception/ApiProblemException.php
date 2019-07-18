<?php

namespace SoftPassio\ApiExceptionBundle\Exception;

use SoftPassio\ApiExceptionBundle\Component\Api\ApiProblemInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiProblemException extends HttpException
{
    private $apiProblem;

    public function __construct(
        ApiProblemInterface $apiProblem,
        \Exception $previous = null,
        array $headers = [],
        $code = 0
    ) {
        $this->apiProblem = $apiProblem;
        $statusCode = $apiProblem->getStatusCode();
        $message = $apiProblem->getTitle();

        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }

    public function getApiProblem()
    {
        return $this->apiProblem;
    }
}

<?php

namespace SoftPassio\ApiExceptionBundle\Factory;

use SoftPassio\ApiExceptionBundle\Component\Api\ApiProblemInterface;
use SoftPassio\ApiExceptionBundle\Component\Factory\ResponseFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiProblemResponseFactory implements ResponseFactoryInterface
{
    public function createResponse(ApiProblemInterface $apiProblem)
    {
        $data = $apiProblem->toArray();

        $response = new JsonResponse(
            $data,
            $apiProblem->getStatusCode()
        );

        $response->headers->set('Content-Type', 'application/problem+json');

        return $response;
    }
}

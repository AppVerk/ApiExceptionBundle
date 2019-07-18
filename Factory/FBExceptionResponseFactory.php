<?php

namespace SoftPassio\ApiExceptionBundle\Factory;

use SoftPassio\ApiExceptionBundle\Component\Api\ApiProblemInterface;
use SoftPassio\ApiExceptionBundle\Component\Factory\ResponseFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class FBExceptionResponseFactory implements ResponseFactoryInterface
{
    public function createResponse(ApiProblemInterface $apiProblem)
    {
        $data = $apiProblem->ToArray();

        $response = new JsonResponse(
            $this->prepareData($data)
        );

        $response->headers->set('Content-Type', 'application/problem+json');

        return $response;
    }

    public function prepareData($data)
    {
        $message = ($data['details']) ? $data['title'].': '.$data['details'] : $data['title'];

        return [
            'error' => [
                'code'    => $data['status'],
                'message' => $message
            ],
        ];
    }
}

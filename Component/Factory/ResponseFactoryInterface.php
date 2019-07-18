<?php

namespace SoftPassio\ApiExceptionBundle\Component\Factory;

use SoftPassio\ApiExceptionBundle\Component\Api\ApiProblemInterface;

interface ResponseFactoryInterface
{
    public function createResponse(ApiProblemInterface $apiProblem);
}

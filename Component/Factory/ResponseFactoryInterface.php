<?php

namespace AppVerk\ApiExceptionBundle\Component\Factory;

use AppVerk\ApiExceptionBundle\Component\Api\ApiProblemInterface;

interface ResponseFactoryInterface
{
    public function createResponse(ApiProblemInterface $apiProblem);
}
<?php

namespace AppVerk\ApiExceptionBundle\Component\Factory;

use AppVerk\ApiExceptionBundle\Component\Api\ApiProblemInterface;

interface ApiProblemFactoryInterface
{
    public function create($statusCode, $type = null, $details = null): ApiProblemInterface;
}
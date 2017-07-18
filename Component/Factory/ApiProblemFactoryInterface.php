<?php

namespace AppVerk\ApiExceptionBundle\Component\Factory;

interface ApiProblemFactoryInterface
{
    public function create($statusCode, $type = null, $details = null);
}

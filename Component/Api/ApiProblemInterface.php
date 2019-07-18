<?php

namespace SoftPassio\ApiExceptionBundle\Component\Api;

interface ApiProblemInterface
{
    public function getStatusCode();

    public function toArray();

    public function getTitle();
}

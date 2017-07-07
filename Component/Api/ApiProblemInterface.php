<?php

namespace AppVerk\ApiExceptionBundle\Component\Api;

interface ApiProblemInterface
{
    public function getStatusCode();

    public function toArray();

    public function getTitle();
}
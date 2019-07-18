<?php

namespace SoftPassio\ApiExceptionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use SoftPassio\ApiExceptionBundle\Exception\ApiProblemException;
use SoftPassio\ApiExceptionBundle\Api\ApiProblem;

class DefaultController extends Controller
{
    public function adminAction()
    {
        $this->makeError();
    }

    public function apiExceptionAction()
    {
        $this->makeError();
    }

    private function makeError()
    {
        $apiProblem = new ApiProblem(Response::HTTP_BAD_REQUEST, ApiProblem::TYPE_VALIDATION_ERROR);
        throw new ApiProblemException($apiProblem);
    }
}

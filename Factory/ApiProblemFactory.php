<?php

namespace SoftPassio\ApiExceptionBundle\Factory;

use SoftPassio\ApiExceptionBundle\Api\ApiProblem;
use SoftPassio\ApiExceptionBundle\Component\Factory\ApiProblemFactoryInterface;
use Symfony\Component\Translation\TranslatorInterface;

class ApiProblemFactory implements ApiProblemFactoryInterface
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function create($statusCode, $type = null, $details = null)
    {
        $apiProblem = new ApiProblem($statusCode, $type);
        if ($details) {
            $apiProblem->set('detail', $this->translator->trans($details));
        }

        return $apiProblem;
    }
}

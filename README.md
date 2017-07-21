# ApiExceptionBundle
[![Build Status](https://travis-ci.org/AppVerk/ApiExceptionBundle.svg?branch=master)](https://travis-ci.org/AppVerk/ApiExceptionBundle)

Catch all Symfony 3.3 errors and convert it to problem+json RFC7807 response

## Installation:

Required the bundle with composer:

    $ php composer.phar require app-verk/api-exception-bundle
    
Add bundle to AppKernel:

    <?php
        // app/AppKernel.php
    
        public function registerBundles()
        {
            $bundles = array(
                // ...
                
                new AppVerk\ApiExceptionBundle\AppVerkApiExceptionBundle(),
            );
        }
        
## Configuration:

AppVerkApiProblemExceptionBundle automatically catch your errors 
by `ApiExceptionSubscriber` and return `application/problem+json` response:

    {
      "detail": "Description of problem",
      "status": 404,
      "type": "about:blank",
      "title": "Not Found"
    }
    
#### changing data structure:
Bundle provide `ResponseFactoryInterface` for overriding response data, if u want change response data.

##### Example usage:

to receive response like:

    {
      "exception": {
          "detail": "Description of problem",
          "status": 404,
          "type": "about:blank",
          "title": "Not Found"
      }
    }
    
create new `CustomResponseFactory`:

    <?php
    
    ...
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
            return [
                'exception' => [
                    $data
                ],
            ];
        }
    }
    
### Config reference:

    app_verk_api_exception:
        response_factory: AppVerk\ApiExceptionBundle\Factory\ApiProblemResponseFactory
        enabled: true
        paths_excluded:
            - /admin/


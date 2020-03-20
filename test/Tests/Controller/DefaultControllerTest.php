<?php

namespace SoftPassio\ApiExceptionBundle\test\Tests\Controller;

use SoftPassio\ApiExceptionBundle\Api\ApiProblem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Event\BeforeEvent;

class DefaultControllerTest extends WebTestCase
{
    /**
     * @var Client
     */
    protected static $staticClient;

    public static function setUpBeforeClass(): void
    {
        $baseUrl = getenv('TEST_BASE_URL');
        self::$staticClient = new Client(
            [
                'base_url' => $baseUrl,
                'defaults' => [
                    'exceptions' => false,
                ],
            ]
        );

        self::$staticClient->getEmitter()
            ->on(
                'before',
                function (BeforeEvent $event) {
                    $path = $event->getRequest()->getPath();
                    if (strpos($path, '/app_test.php') === false) {
                        $event->getRequest()->setPath('/app_test.php'.$path);
                    }
                }
            );

        self::bootKernel();
    }

    public function testDefaultException()
    {
        $response = self::$staticClient->get('/default/exception');

        $this->assertNotEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertEquals('application/problem+json', $response->getHeader('Content-Type'));
        $data = json_decode($response->getBody()->getContents());

        $this->assertObjectHasAttribute("status", $data);
        $this->assertObjectHasAttribute('type', $data);
        $this->assertEquals(ApiProblem::TYPE_VALIDATION_ERROR, $data->type);
    }

    public function testAdminException()
    {
        $response = self::$staticClient->get('/admin/exception');

        $this->assertNotEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertNotEquals('application/problem+json', $response->getHeader('Content-Type'));
    }
}

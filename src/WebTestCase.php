<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace FastD\Testing;


use FastD\Http\ServerRequest;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Psr\Http\Message\ResponseInterface;
use FastD\Http\JsonResponse;

/**
 * Class TestCase
 * @package FastD\Testing
 */
abstract class WebTestCase extends PHPUnitTestCase
{
    const JSON_OPTION = JSON_UNESCAPED_UNICODE;

    /**
     * @return bool
     */
    public function isLocal(): bool
    {
        $addr = gethostbyname(gethostname());

        return '127.' === substr($addr, 0, 4) || '::1' === $addr;
    }

    /**
     * @param string $method
     * @param string $path
     * @param array $headers
     * @return ServerRequest
     */
    public function request(string $method, string $path, array $headers = [])
    {
        return new ServerRequest($method, $path, $headers);
    }

    /**
     * @deprecated
     * @param ResponseInterface $response
     * @param $assert
     */
    public function response(ResponseInterface $response, $assert)
    {
        $this->equalsResponse($response, $assert);
    }


    /**
     * @param ResponseInterface $response
     * @param $assert
     */
    public function equalsResponse(ResponseInterface $response, $assert)
    {
        $this->assertEquals($assert, (string) $response->getBody());
    }

    /**
     * @param ResponseInterface $response
     */
    public function equalsResponseEmpty(ResponseInterface $response)
    {
        $result = json_decode((string) $response->getBody(), true);
        $this->assertEmpty($result);
    }

    /**
     * @param ResponseInterface $response
     * @param $count
     */
    public function equalsResponseCount(ResponseInterface $response, $count)
    {
        $result = json_decode((string) $response->getBody(), true);
        $this->assertCount($count, $result);
    }

    /**
     * @deprecated
     * @param ResponseInterface $response
     * @param array $assert
     */
    public function json(ResponseInterface $response, array $assert)
    {
        $this->equalsJson($response, $assert);
    }

    /**
     * @param ResponseInterface $response
     * @param array $assert
     */
    public function equalsJson(ResponseInterface $response, array $assert)
    {
        $this->assertEquals(json_encode($assert, JsonResponse::JSON_OPTIONS), (string) $response->getBody());
    }

    /**
     * @param ResponseInterface $response
     * @param $key
     */
    public function equalsJsonResponseHasKey(ResponseInterface $response, $key)
    {
        $json = (string) $response->getBody();
        $array = json_decode($json, true);

        if (is_string($key)) {
            $keys = [$key];
        } else {
            $keys = $key;
        }

        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $array);
        }
    }

    /**
     * @deprecated
     * @param ResponseInterface $response
     * @param $statusCode
     */
    public function status(ResponseInterface $response, $statusCode)
    {
        $this->equalsStatus($response, $statusCode);
    }

    /**
     * @param ResponseInterface $response
     * @param $statusCode
     */
    public function equalsStatus(ResponseInterface $response, $statusCode)
    {
        $this->assertEquals($statusCode, $response->getStatusCode());
    }

    /**
     * @param ResponseInterface $response
     */
    public function isServerInterval(ResponseInterface $response)
    {
        $this->assertEquals(500, $response->getStatusCode());
    }

    /**
     * @param ResponseInterface $response
     */
    public function isBadRequest(ResponseInterface $response)
    {
        $this->assertEquals(400, $response->getStatusCode());
    }

    /**
     * @param ResponseInterface $response
     */
    public function isNotFound(ResponseInterface $response)
    {
        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * @param ResponseInterface $response
     */
    public function isSuccessful(ResponseInterface $response)
    {
        $this->assertEquals(200, $response->getStatusCode());
    }
}

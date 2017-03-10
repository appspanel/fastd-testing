<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace FastD\Testing;


use Faker\Factory;
use FastD\Http\ServerRequest;
use PHPUnit_Extensions_Database_DataSet_IDataSet;
use PHPUnit_Extensions_Database_DB_IDatabaseConnection;
use PHPUnit_Extensions_Database_TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Class TestCase
 * @package FastD\Testing
 */
class WebTestCase extends PHPUnit_Extensions_Database_TestCase
{
    /**
     * @param $method
     * @param $path
     * @param array $headers
     * @return ServerRequest
     */
    public function request($method, $path, array $headers = [])
    {
        $serverRequest = new ServerRequest($method, $path, $headers);

        return $serverRequest;
    }

    /**
     * @param ResponseInterface $response
     * @param $assert
     */
    public function response(ResponseInterface $response, $assert)
    {
        $this->assertEquals((string) $response->getBody(), $assert);
    }

    /**
     * @param ResponseInterface $response
     * @param array $assert
     */
    public function json(ResponseInterface $response, array $assert)
    {
        $this->assertEquals((string) $response->getBody(), json_encode($assert));
    }

    /**
     * @param ResponseInterface $response
     * @param $statusCode
     */
    public function status(ResponseInterface $response, $statusCode)
    {
        $this->assertEquals($response->getStatusCode(), $statusCode);
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

    /**
     * Returns the test database connection.
     *
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    protected function getConnection()
    {
    }

    /**
     * Returns the test dataset.
     *
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
    }
}
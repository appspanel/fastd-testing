<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */


use FastD\Http\Response;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

include_once __DIR__ . '/TestCase.php';

class TestCaseTest extends PHPUnitTestCase
{
    public function testTestCaseFakeData()
    {
        $testing = new TestCase();

        $serverRequest = $testing->request('GET', '/');

        $this->assertEquals('/', $serverRequest->getUri()->getPath());
    }

    public function testTestCaseHandleResponse()
    {
        $testing = new TestCase();

        $testing->equalsResponse(new Response('hello world'), 'hello world');
    }

    public function testLocal()
    {
        $testing = new TestCase();

        if ($testing->isLocal()) {
            $this->assertTrue(true);
        } else {
            $this->assertFalse(false);
        }
    }
}

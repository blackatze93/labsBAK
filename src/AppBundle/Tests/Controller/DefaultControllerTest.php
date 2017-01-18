<?php

namespace Appbundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class DefaultControllerTest
 */
class DefaultControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = self::createClient();
    }

    public function testIndex()
    {
        $this->client->request('GET', '/');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }
}

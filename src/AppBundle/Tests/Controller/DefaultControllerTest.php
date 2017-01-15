<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class DependenciaControllerTest.
 */
class DefaultControllerTest extends WebTestCase
{
    /**
     * Test que comprueba la carga de la aplicacion.
     */
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /");
    }
}

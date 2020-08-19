<?php

namespace App\Tests\Controller;

use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UsersControllerTest extends WebTestCase
{
    public function testGetUsersViaDatabaseReturnJson()
    {
        $client = static::createClient();

        $client->request('GET', '/api/v1/users?source=database');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testGetUsersWithoutSourceReturnError()
    {
        $client = static::createClient();

        $client->request('GET', '/api/v1/users');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $result = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('errors', $result);
        $this->assertArrayHasKey('source', $result['errors'][0]);
        $this->assertEquals('Allowed data source is xml or database.', $result['errors'][0]['source']);
    }
}

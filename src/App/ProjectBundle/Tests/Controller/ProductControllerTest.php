<?php

namespace App\ProjectBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testShow()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/product/6');//{id}

        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testAddComment()
    {
        $client = static::createClient();

        $crawler = $client->request(
            'POST',
            '/product/6/add-comment',
            array('title' => 'Unit test title', 'body' => 'Unit test body')
        );

        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
    }
}

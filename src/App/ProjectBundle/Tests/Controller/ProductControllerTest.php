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
            200, // or Symfony\Component\HttpFoundation\Response::HTTP_OK
            $client->getResponse()->getStatusCode()
        );
    }

    public function testAddComment()
    {
        $client = static::createClient();

//        $crawler = $client->request(
//            'POST',
//            '/product/6/add-comment',
//            array(),
//            array(),
//            array('CONTENT_TYPE' => 'application/json'),//'CONTENT_TYPE' => 'application/json'
//            '{"title":"Unit test title", "body":"Unit test body"}'
//        );

        $crawler = $client->request(
            'POST',
            '/product/6/add-comment',
            array('title' => 'Unit test title', 'body' => 'Unit test body')
        );

        $this->assertEquals(
            200, // or Symfony\Component\HttpFoundation\Response::HTTP_OK
            $client->getResponse()->getStatusCode()
        );

//        $this->assertContains(
//            'Hello World',
//            $client->getResponse()->getContent()
//        );
    }
}

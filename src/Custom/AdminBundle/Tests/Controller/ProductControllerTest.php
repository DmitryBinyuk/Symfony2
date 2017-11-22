<?php

namespace Custom\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/custom-admin/products');

        $this->assertContains(
            '<h2>Products</h2>',
            $client->getResponse()->getContent()
        );

        //Test creation link
        $link = $crawler->selectLink('Create product')->link();

        $client->click($link);

        $this->assertContains(
            '<h3>Create product:</h3>',
            $client->getResponse()->getContent()
        );
    }

    public function testShow()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/custom-admin/products/show/6');

        $this->assertContains(
            '<h3>View product:</h3>',
            $client->getResponse()->getContent()
        );

        //Test "back" link
        $link = $crawler->selectLink('Back')->link();

        $client->click($link);

        $this->assertContains(
            '<h2>Products</h2>',
            $client->getResponse()->getContent()
        );

        //Negative test
        $crawler = $client->request('GET', '/custom-admin/products/show/abrakadabra');
        $this->assertEquals(
            404,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testCreate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/custom-admin/products/create');

        $this->assertContains(
            '<h3>Create product:</h3>',
            $client->getResponse()->getContent()
        );

        //Test submit
        $form = $crawler->selectButton('Create Product')->form();

        // set some values
        $form['form[name]'] = 'name_test_unit_create';
        $form['form[description]'] = 'description_test_unit_create';
        $form['form[price]'] = 1;
        $form['form[category]'] = 2;

        // submit the form
        $crawler = $client->submit($form);


        //Test redirect to product list page after creation
        $this->assertEquals(
            302,
            $client->getResponse()->getStatusCode()
        );

        $this->assertTrue(
            $client->getResponse()->isRedirect('/custom-admin/products')
        );
    }

    public function testUpdate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/custom-admin/products/update/6');

        $this->assertContains(
            '<h3>Update product:</h3>',
            $client->getResponse()->getContent()
        );

        //Test submit
        $form = $crawler->selectButton('Update')->form();

        // set some values
        $form['form[name]'] = 'name_test_unit_update';
        $form['form[description]'] = 'description_test_unit_update';
        $form['form[price]'] = 1;
        $form['form[category]'] = 2;

        // submit the form
        $crawler = $client->submit($form);


        //Test redirect to product list page after creation
        $this->assertEquals(
            302,
            $client->getResponse()->getStatusCode()
        );

        $this->assertTrue(
            $client->getResponse()->isRedirect('/custom-admin/products')
        );

        //Negative test
        $crawler = $client->request('GET', '/custom-admin/products/update/abrakadabra');
        $this->assertEquals(
            404,
            $client->getResponse()->getStatusCode()
        );
    }
}

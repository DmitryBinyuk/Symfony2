<?php

namespace Custom\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductCategoryControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/custom-admin/product-categories');

        $this->assertContains(
            '<h3>Products categories:</h3>',
            $client->getResponse()->getContent()
        );

        //Test creation link
        $link = $crawler->selectLink('Create category')->link();

        $client->click($link);

        $this->assertContains(
            '<h3>Create product category:</h3>',
            $client->getResponse()->getContent()
        );
    }

    public function testShow()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/custom-admin/product-categories/show/2');

        $this->assertContains(
            '<h3>View product category:</h3>',
            $client->getResponse()->getContent()
        );

        //Test "back" link
        $link = $crawler->selectLink('Back')->link();

        $client->click($link);

        $this->assertContains(
            '<h3>Products categories:</h3>',
            $client->getResponse()->getContent()
        );

        //Negative test
        $crawler = $client->request('GET', '/custom-admin/product-categories/show/abrakadabra');
        $this->assertEquals(
            500,
            $client->getResponse()->getStatusCode()
        );

        $this->assertContains(
            'No result was found for query although at least one row was expected.',
            $client->getResponse()->getContent()
        );
    }

    public function testCreate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/custom-admin/product-categories/create');

        $this->assertContains(
            '<h3>Create product category:</h3>',
            $client->getResponse()->getContent()
        );

        //Test submit
        $form = $crawler->selectButton('Create Category')->form();

        // set some values
        $form['form[name]'] = 'name_test_unit_create';
        $form['form[description]'] = 'description_test_unit_create';

        // submit the form
        $crawler = $client->submit($form);


        //Test redirect to product list page after creation
        $this->assertEquals(
            302,
            $client->getResponse()->getStatusCode()
        );

        $this->assertTrue(
            $client->getResponse()->isRedirect('/custom-admin/product-categories')
        );
    }

    public function testUpdate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/custom-admin/product-categories/update/2');

        $this->assertContains(
            '<h3>Update product category</h3>',
            $client->getResponse()->getContent()
        );

        //Test submit
        $form = $crawler->selectButton('Update')->form();

        // set some values
        $form['form[name]'] = 'name_test_unit_update';
        $form['form[description]'] = 'description_test_unit_update';

        // submit the form
        $crawler = $client->submit($form);


        //Test redirect to product list page after creation
        $this->assertEquals(
            302,
            $client->getResponse()->getStatusCode()
        );

        $this->assertTrue(
            $client->getResponse()->isRedirect('/custom-admin/product-categories')
        );

        //Negative test
        $crawler = $client->request('GET', '/custom-admin/product-categories/update/abrakadabra');
        $this->assertEquals(
            404,
            $client->getResponse()->getStatusCode()
        );
    }
}

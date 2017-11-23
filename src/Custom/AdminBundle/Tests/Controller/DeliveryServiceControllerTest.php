<?php

namespace Custom\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DeliveryServiceControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/custom-admin/delivery-services');

        $this->assertContains(
            '<h3>Delivery Services:</h3>',
            $client->getResponse()->getContent()
        );

        //Test creation link
        $link = $crawler->selectLink('Create Delivery Service')->link();

        $client->click($link);

        $this->assertContains(
            '<h3>Create Delivery Service:</h3>',
            $client->getResponse()->getContent()
        );
    }

    public function testShow()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/custom-admin/delivery-services/show/1');

        $this->assertContains(
            '<h3>View Delivery Service:</h3>',
            $client->getResponse()->getContent()
        );

        //Test "back" link
        $link = $crawler->selectLink('Back')->link();

        $client->click($link);

        $this->assertContains(
            '<h3>Delivery Services:</h3>',
            $client->getResponse()->getContent()
        );

        //Negative test
        $crawler = $client->request('GET', '/custom-admin/delivery-services/show/abrakadabra');
        $this->assertEquals(
            404,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testCreate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/custom-admin/delivery-services/create');

        $this->assertContains(
            '<h3>Create Delivery Service:</h3>',
            $client->getResponse()->getContent()
        );

        //Test submit
        $form = $crawler->selectButton('Create Delivery Service')->form();

        // set some values
        $form['form[name]'] = 'name_test_unit_create';
        $form['form[pricePerKilometer]'] = 'pricePerKilometer_test_unit_create';

        // submit the form
        $crawler = $client->submit($form);


        //Test redirect to product list page after creation
        $this->assertEquals(
            302,
            $client->getResponse()->getStatusCode()
        );

        $this->assertTrue(
            $client->getResponse()->isRedirect('/custom-admin/delivery-services')
        );
    }

    public function testUpdate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/custom-admin/delivery-services/update/1');

        $this->assertContains(
            '<h3>Update Delivery Service:</h3>',
            $client->getResponse()->getContent()
        );

        //Test submit
        $form = $crawler->selectButton('Update')->form();

        // set some values
        $form['form[name]'] = 'name_test_unit_update';
        $form['form[pricePerKilometer]'] = 'pricePerKilometer_test_unit_update';

        // submit the form
        $crawler = $client->submit($form);


        //Test redirect to product list page after creation
        $this->assertEquals(
            302,
            $client->getResponse()->getStatusCode()
        );

        $this->assertTrue(
            $client->getResponse()->isRedirect('/custom-admin/delivery-services')
        );

        //Negative test
        $crawler = $client->request('GET', '/custom-admin/delivery-services/update/abrakadabra');
        $this->assertEquals(
            404,
            $client->getResponse()->getStatusCode()
        );
    }
}

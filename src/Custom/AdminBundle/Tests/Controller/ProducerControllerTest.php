<?php

namespace Custom\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProducerControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/custom-admin/producers');

        $this->assertContains(
            '<h2>Producers:</h2>',
            $client->getResponse()->getContent()
        );

        //Test creation link
        $link = $crawler->selectLink('Create producer')->link();

        $client->click($link);

        $this->assertContains(
            '<h3>Create producer:</h3>',
            $client->getResponse()->getContent()
        );
    }

    public function testShow()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/custom-admin/producers/show/1');

        $this->assertContains(
            '<h3>View producer:</h3>',
            $client->getResponse()->getContent()
        );

        //Test "back" link
        $link = $crawler->selectLink('Back')->link();

        $client->click($link);

        $this->assertContains(
            '<h2>Producers:</h2>',
            $client->getResponse()->getContent()
        );

        //Negative test
        $crawler = $client->request('GET', '/custom-admin/producers/show/abrakadabra');
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

        $crawler = $client->request('GET', '/custom-admin/producers/create');

        $this->assertContains(
            '<h3>Create producer:</h3>',
            $client->getResponse()->getContent()
        );

        //Test submit
        $form = $crawler->selectButton('Create Producer')->form();

        // set some values
        $form['form[name]'] = 'name_test_unit_create';
        $form['form[country]'] = 'Unit_test_country_create';
        $form['form[description]'] = 'description_test_unit_create';

        // submit the form
        $crawler = $client->submit($form);


        //Test redirect to producer list page after creation
        $this->assertEquals(
            302,
            $client->getResponse()->getStatusCode()
        );

        $this->assertTrue(
            $client->getResponse()->isRedirect('/custom-admin/producers')
        );
    }

    public function testUpdate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/custom-admin/producers/update/2');

        $this->assertContains(
            '<h3>Update producer:</h3>',
            $client->getResponse()->getContent()
        );

        //Test submit
        $form = $crawler->selectButton('Update')->form();

        // set some values
        $form['form[name]'] = 'name_test_unit_update';
        $form['form[country]'] = 'Unit_test_country_update';
        $form['form[description]'] = 'description_test_unit_update';

        // submit the form
        $crawler = $client->submit($form);


        //Test redirect to producer list page after update
        $this->assertEquals(
            302,
            $client->getResponse()->getStatusCode()
        );

        $this->assertTrue(
            $client->getResponse()->isRedirect('/custom-admin/producers')
        );

        //Negative test
        $crawler = $client->request('GET', '/custom-admin/products/update/abrakadabra');
        $this->assertEquals(
            404,
            $client->getResponse()->getStatusCode()
        );
    }
}

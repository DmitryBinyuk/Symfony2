<?php

namespace Custom\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ManagerControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/custom-admin/managers');

        $this->assertContains(
            '<h3>Managers:</h3>',
            $client->getResponse()->getContent()
        );

        //Test creation link
        $link = $crawler->selectLink('Create manager')->link();

        $client->click($link);

        $this->assertContains(
            '<h3>Create manager:</h3>',
            $client->getResponse()->getContent()
        );
    }

    public function testShow()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/custom-admin/managers/show/1');

        $this->assertContains(
            '<h3>View manager:</h3>',
            $client->getResponse()->getContent()
        );

        //Test "back" link
        $link = $crawler->selectLink('Back')->link();

        $client->click($link);

        $this->assertContains(
            '<h3>Managers:</h3>',
            $client->getResponse()->getContent()
        );

        //Negative test
        $crawler = $client->request('GET', '/custom-admin/managers/show/abrakadabra');
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

        $crawler = $client->request('GET', '/custom-admin/managers/create');

        $this->assertContains(
            '<h3>Create manager:</h3>',
            $client->getResponse()->getContent()
        );

        //Test submit
        $form = $crawler->selectButton('Create Manager')->form();

        // set some values
        $form['form[fullname]'] = 'fullname_test_unit_create';
        $form['form[position]'] = 'position_test_unit_create';
        $form['form[phone]'] = '11111';
        $form['form[contact_email]'] = 'unit_test.ya.ru';

        // submit the form
        $crawler = $client->submit($form);


        //Test redirect to manager list page after creation
        $this->assertEquals(
            302,
            $client->getResponse()->getStatusCode()
        );

        $this->assertTrue(
            $client->getResponse()->isRedirect('/custom-admin/managers')
        );
    }
}

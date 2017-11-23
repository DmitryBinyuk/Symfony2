<?php

namespace Custom\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/custom-admin/users');

        $this->assertContains(
            '<h3>Users:</h3>',
            $client->getResponse()->getContent()
        );

        //Test creation link
        $link = $crawler->selectLink('Create user')->link();

        $client->click($link);

        $this->assertContains(
            '<h3>Create user:</h3>',
            $client->getResponse()->getContent()
        );
    }

    public function testShow()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/custom-admin/users/show/6');

        $this->assertContains(
            '<h3>View user:</h3>',
            $client->getResponse()->getContent()
        );

        //Test "back" link
        $link = $crawler->selectLink('Back')->link();

        $client->click($link);

        $this->assertContains(
            '<h3>Users:</h3>',
            $client->getResponse()->getContent()
        );

        //Negative test
        $crawler = $client->request('GET', '/custom-admin/users/show/abrakadabra');
        $this->assertEquals(
            404,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testCreate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/custom-admin/users/create');

        $this->assertContains(
            '<h3>Create user:</h3>',
            $client->getResponse()->getContent()
        );

        //Test submit
        $form = $crawler->selectButton('Create User')->form();

        // set some values
        $form['form[username]'] = 'name_test_unit_create';
        $form['form[email]'] = 'email_test_unit_create@ya.ru';
        $form['form[email_canonical]'] = 'email_canonical_test_unit_create@ya.ru';
        $form['form[password]'] = 111111;

        // submit the form
        $crawler = $client->submit($form);


        //Test redirect to users list page after creation
        $this->assertEquals(
            302,
            $client->getResponse()->getStatusCode()
        );

        $this->assertTrue(
            $client->getResponse()->isRedirect('/custom-admin/users')
        );
    }

    public function testUpdate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/custom-admin/users/update/10');

        $this->assertContains(
            '<h3>Update user:</h3>',
            $client->getResponse()->getContent()
        );

        //Test submit
        $form = $crawler->selectButton('Update')->form();

        // set some values
        $form['form[username]'] = 'name_test_unit_create';
        $form['form[email]'] = 'email_test_unit_update@ya.ru';
        $form['form[email_canonical]'] = 'email_canonical_test_unit_update@ya.ru';
        $form['form[password]'] = 111111;

        // submit the form
        $crawler = $client->submit($form);


        //Test redirect to product list page after creation
        $this->assertEquals(
            302,
            $client->getResponse()->getStatusCode()
        );

        $this->assertTrue(
            $client->getResponse()->isRedirect('/custom-admin/users')
        );

        //Negative test
        $crawler = $client->request('GET', '/custom-admin/users/update/abrakadabra');
        $this->assertEquals(
            404,
            $client->getResponse()->getStatusCode()
        );
    }
}

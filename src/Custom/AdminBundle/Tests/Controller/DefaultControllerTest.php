<?php

namespace Custom\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
//    public function testIndex()
//    {
//        $client = static::createClient();
//
//        $crawler = $client->request('GET', '/hello/Fabien');
//
//        $this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);
//    }

    public function testLogin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $this->assertContains(
            'Authentication',
            $client->getResponse()->getContent()
        );

        //Test submit
        $form = $crawler->selectButton('Login')->form();

        // set some values
        $form['_username'] = 'test';
        $form['_password'] = 111111;

        // submit the form
        $crawler = $client->submit($form);


        //Test redirect to users list page after creation
        $this->assertEquals(
            302,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testRegister()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/register/');

        $this->assertContains(
            'Register',
            $client->getResponse()->getContent()
        );

        //Test submit
        $form = $crawler->selectButton('Register')->form();

        // set some values
        $form['fos_user_registration_form[username]'] = 'test';
        $form['fos_user_registration_form[email]'] = 'unit_test_register'.rand(1,100).'@ya.ru';
        $form['fos_user_registration_form[plainPassword][first]'] = 111111;
        $form['fos_user_registration_form[plainPassword][second]'] = 111111;

        // submit the form
        $crawler = $client->submit($form);


        //Test redirect to users list page after creation
        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
    }
}

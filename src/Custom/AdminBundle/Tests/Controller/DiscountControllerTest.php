<?php

namespace Custom\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DiscountControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/custom-admin/discounts');

        $this->assertContains(
            '<h3>Discounts:</h3>',
            $client->getResponse()->getContent()
        );

        //Test creation link
        $link = $crawler->selectLink('Create discount')->link();

        $client->click($link);

        $this->assertContains(
            '<h3>Create discount:</h3>',
            $client->getResponse()->getContent()
        );
    }

    public function testShow()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/custom-admin/discounts/show/4');

        $this->assertContains(
            '<h3>View discount:</h3>',
            $client->getResponse()->getContent()
        );

        //Test "back" link
        $link = $crawler->selectLink('Back')->link();

        $client->click($link);

        $this->assertContains(
            '<h3>Discounts:</h3>',
            $client->getResponse()->getContent()
        );

        //Negative test
        $crawler = $client->request('GET', '/custom-admin/discounts/show/abrakadabra');
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

        $crawler = $client->request('GET', '/custom-admin/discounts/create');

        $this->assertContains(
            '<h3>Create discount:</h3>',
            $client->getResponse()->getContent()
        );

        //Test submit
        $form = $crawler->selectButton('Create Discount')->form();

        // set some values
        $form['form[title]'] = 'title_test_unit_create';
        $form['form[total_count]'] = 'total_count_test_unit_create';
        $form['form[total_price]'] = 1111;
        $form['form[discount_size_percent]'] = 15;

        // submit the form
        $crawler = $client->submit($form);


        //Test redirect to discounts list page after creation
        $this->assertEquals(
            302,
            $client->getResponse()->getStatusCode()
        );

        $this->assertTrue(
            $client->getResponse()->isRedirect('/custom-admin/discounts')
        );
    }

    public function testUpdate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/custom-admin/products/discounts/6');

        $this->assertContains(
            '<h3>Update discount:</h3>',
            $client->getResponse()->getContent()
        );

        //Test submit
        $form = $crawler->selectButton('Update')->form();

        // set some values
        $form['form[title]'] = 'title_test_unit_update';
        $form['form[total_count]'] = 'total_count_test_unit_update';
        $form['form[total_price]'] = 1111;
        $form['form[discount_size_percent]'] = 15;

        // submit the form
        $crawler = $client->submit($form);


        //Test redirect to discounts list page after creation
        $this->assertEquals(
            302,
            $client->getResponse()->getStatusCode()
        );

        $this->assertTrue(
            $client->getResponse()->isRedirect('/custom-admin/discounts')
        );

        //Negative test
        $crawler = $client->request('GET', '/custom-admin/discounts/update/abrakadabra');
        $this->assertEquals(
            404,
            $client->getResponse()->getStatusCode()
        );
    }
}

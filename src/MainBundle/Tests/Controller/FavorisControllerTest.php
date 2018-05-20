<?php

namespace MainBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FavorisControllerControllerTest extends WebTestCase
{
    public function testAjout()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/fav/ajout');
    }

    public function testSupp()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/fav/supp');
    }

    public function testAffiche()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/fav/affiche');
    }

}

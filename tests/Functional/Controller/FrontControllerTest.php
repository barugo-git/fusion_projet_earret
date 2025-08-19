<?php


namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FrontControllerTest extends WebTestCase
{

    public function  testEnclosuresAreShowOnTheHomepage(){

        $client= $this->createClient();
        $crawler=$client->request('GET','/');
        $this->assertStatusCode(200,$client);

    }

}
<?php

require_once 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

final class UserTest extends TestCase{
    private $http;

    protected function setUp(): void
    {
        $this->http = new Client([
            'base_uri' => 'http://localhost:5000'
        ]);
    }

    public function tearDown(): void {
        $this->http = null;
    }

    /**
     * @test
     */
    public function should_create_new_user(){
        $user = $this->userData();
        //post data to registration end-point
        
        // $this->post('/api/v1/register', $user);
        $response = $this->http->post('/users', $user);

        $this->assertEquals(201, $response->getStatusCode());
    }

    private function userData(){
        return [
            'surname' => 'smith',
            'firstName' => 'john',
            'email' => 'john@example.com'
        ];

    }
}
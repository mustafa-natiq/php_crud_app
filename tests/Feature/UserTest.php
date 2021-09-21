<?php

require_once 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

final class UserTest extends TestCase{
    private static $http;
    private static $pid;

    public static function setUpBeforeClass(): void
    {
        // $command = 'php -S 127.0.0.1:9000 -t ../../public > /dev/null 2>&1 & echo $!';
        // $output = array();
        // exec($command, $output);
        // echo "server started ";
        
        // self::$pid = (int) $output[0];

        self::$http = new Client([
            'base_uri' => 'http://localhost:5000'
        ]);
    }

    public static function tearDownAfterClass(): void {
        self::$http = null;
        // exec('kill ' . self::$pid);
    }

    /**
     * @test
     */
    public function should_create_new_user(){
        $user = $this->userData();
        //post data to registration end-point
        
        // $this->post('/api/v1/register', $user);
        $response = self::$http->post('/users', $user);

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
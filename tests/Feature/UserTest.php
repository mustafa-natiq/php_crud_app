<?php

require_once 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;
use GuzzleHttp\Client;

final class UserTest extends TestCase{
    private static $http;
    private static $pid;
    protected static $process;

    const ENVIRONMENT = "production";
    const HOST = "0.0.0.0";
    const PORT = 5000;

    public static function setUpBeforeClass(): void
    {
        // $command = 'php -S 127.0.0.1:5000 -t ../../public > /dev/null 2>&1 & echo $!';
        
        // $command = sprintf(
        //     'php -S %s:%d -t %s %s & echo $!',
        //     self::ENVIRONMENT,
        //     self::HOST,
        //     self::PORT,
        //     realpath(__DIR__.'/public'),
        //     realpath(__DIR__.'/public/index.php')
        //   );
        //   $command = 'php -S 127.0.0.1:5000 -t public';
          $command = 'php -S 127.0.0.1:5000 -t public >/dev/null 2>&1 & echo $!';
          
        $output = array();
        exec($command, $output);
        self::$pid = (int) $output[0];
        sleep(2);
        

        // // Using Symfony/Process to get a handler for starting a new process
        // self::$process = new Process([$command]);
        // // Disabling the output, otherwise the process might hang after too much output
        // self::$process->disableOutput();
        // // Actually execute the command and start the process
        // self::$process->start();

        $start = microtime(true);
        $connected = false;

        // Try to connect until the time spent exceeds the timeout specified in the configuration
        // while (microtime(true) - $start <= 100000) {
        //     if (self::canConnectToHttpd('0.0.0.0', 5000)) {
        //         $connected = true;
        //         break;
        //     }
        // }

        if (self::canConnectToHttpd('0.0.0.0', 5000)) {
                    $connected = true;
        }

        if (!$connected) {
            self::killProcess(self::$pid);
            throw new RuntimeException(
                sprintf(
                    'Could not connect to the web server within the given timeframe (%d second(s))',
                    1
                )
            );
        }
        echo "server started ";
        
        
        

        self::$http = new Client([
            'base_uri' => 'http://127.0.0.1:5000'
        ]);
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

     /**
     * Kill a process
     *
     * @param int $pid
     */
    private static function killProcess($pid) {
        exec('kill ' . (int) $pid);
    }

    private static function execInBackground($cmd) { 
        if (substr(php_uname(), 0, 7) == "Windows"){ 
            pclose(popen("start /B ". $cmd . ' echo $!', "r"));  
        } 
        else { 
            exec($cmd . " > /dev/null & echo $!");   
        } 
    }

    /**
     * See if we can connect to the httpd
     *
     * @param string $host The hostname to connect to
     * @param int $port The port to use
     * @return boolean
     */
    private static function canConnectToHttpd($host, $port) {
        // Disable error handler for now
        set_error_handler(function() { return true; });

        // Try to open a connection
        $sp = fsockopen($host, $port);

        // Restore the handler
        restore_error_handler();

        if ($sp === false) {
            return false;
        }

        fclose($sp);

        return true;
    }

    public static function tearDownAfterClass(): void {
        self::$http = null;
        
        if (self::$pid) {
            self::killProcess(self::$pid);
        }
    }

    private function userData(){
        return [
            'surname' => 'smith',
            'firstName' => 'john',
            'email' => 'john@example.com'
        ];

    }
}
<?php
/**
 * Created by PhpStorm.
 * User: tomconte
 * Date: 09/03/2016
 * Time: 17:12
 */

namespace AzureIoTHub;

use GuzzleHttp\Client;
use AzureIoTHub;

class IoTHubClientTest extends \PHPUnit_Framework_TestCase
{
    public function testSend()
    {
        $host = 'tcontehub.azure-devices.net';
        $deviceId = 'power_lawyer';
        $deviceKey = 'dJ2tReWUTOpBrzBzvJH8Uj6CCWv7FVtO1ZN7LvwwjCA=';

        $client = new IoTHubClient($host, $deviceId, $deviceKey);
        $response = $client->Send('Hello World!');

        // Response code should be 204 if the message was accepted
        $this->assertEquals($response->getStatusCode(), 204);
    }
}

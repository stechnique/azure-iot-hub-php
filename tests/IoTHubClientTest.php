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
    public function testSendEvent()
    {
        $host = 'hubbhub.azure-devices.net';
        $deviceId = 'php_device';
        $deviceKey = 'xxxx';

        $client = new DeviceClient($host, $deviceId, $deviceKey);
        $response = $client->sendEvent('Hello World!');

        // Response code should be 204 if the message was accepted
        $this->assertEquals($response->getStatusCode(), 204);
    }

    public function testSendEventWithConnectionString()
    {
        $connectionString = 'HostName=hubbhub.azure-devices.net;DeviceId=php_device;SharedAccessKey=xxxx';

        $client = new DeviceClient($connectionString);
        $response = $client->sendEvent('Hello World!');

        // Response code should be 204 if the message was accepted
        $this->assertEquals($response->getStatusCode(), 204);
    }
}

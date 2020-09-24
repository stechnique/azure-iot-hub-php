# A PHP library to send data to Azure IoT Hub

Currently the library is [hosted on my GitHub account](https://github.com/stechnique/azure-iot-hub-php), so in order to use it, your `composer.json` file should contain something like this:

~~~ json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/stechnique/azure-iot-hub-php"
        }
    ],
    "require": {
        "stechnique/azure-iot-hub": "dev-master"
    }
}
~~~

This will load the Composer package directly from GitHub. Then you can use it that way:

~~~ php
<?php

require __DIR__ . '/vendor/autoload.php';

$host = 'hubbhub.azure-devices.net';
$deviceId = 'php_device';
$deviceKey = 'xxxxy5TAxxxx73VBxxxxq4WNxxxxaTIPxxxxEvkCxxxx';

$client = new AzureIoTHub\DeviceClient($host, $deviceId, $deviceKey);

$response = $client->sendEvent('Hello World!');

print($response->getStatusCode());
~~~

In order to find the values for `host`, `deviceId` and `deviceKey`, you can follow our [Get started with Azure IoT Hub](Get started with Azure IoT Hub) article. Basically, you will use the portal to create an IoT Hub, and then you will use our `iothub-explorer` command-line tool to generate a new device and its associated secret keys.

You can also use a connection string to create the client:

~~~ php
$connectionString = 'HostName=hubbhub.azure-devices.net;DeviceId=php_device;SharedAccessKey=xxxx';
$client = new DeviceClient($connectionString);
~~~

This fork from Tom Conté's repo was made to rely on an older version of Guzzle (5.3) for our specific use case and requirements. You should use the original library if you can use Guzzle 6. However, in this version the Guzzle client is reused for subsequent events. Our use case is to open a connection and burst a few messages before disconnecting. 

Please note that as with all IoT Hub libraries, your secret key is never sent on the wire. The library will compute a Shared Access Signature (SAS) token and use it to authenticate the communication; you can look at the `computeSAS()` function in the source code to see how this is done.

Please use the GitHub repo if you use this little library and have any feedback, questions or issues!

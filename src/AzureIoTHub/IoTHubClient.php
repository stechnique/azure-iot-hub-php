<?php
/**
 * Created by PhpStorm.
 * User: tomconte
 * Date: 08/03/2016
 * Time: 17:44
 */

namespace AzureIoTHub;

use GuzzleHttp\Client;

class IoTHubClient
{
    private $host, $deviceId, $deviceKey, $SAS;

    /**
     * IoTHubClient constructor.
     *
     * @param string $host the Azure IoT Hub full host name
     * @param string $deviceId the device identifier
     * @param string $deviceKey one of the device secret keys
     */
    function __construct($host, $deviceId, $deviceKey)
    {
        $this->host = $host;
        $this->deviceId = $deviceId;
        $this->deviceKey = $deviceKey;
        // Assemble the Resource URI
        $resourceURI = $this->host . '/devices/' . $this->deviceId;
        // Default expiry of 1 hour should be enough as most PHP objects are short lived anyway
        $expiry = time() + 3600;
        // Compute the SAS
        $this->SAS = $this->computeSAS($resourceURI, $this->deviceKey, $expiry);
    }

    /**
     * Send some data to the IoT Hub.
     *
     * @param $data
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    function Send($data)
    {
        $uri = '/devices/' . $this->deviceId . '/messages/events?api-version=2016-02-03';
        $client = new Client([
            'base_uri' => 'https://' . $this->host
        ]);

        $response = $client->request('POST', $uri, [
            'body' => $data,
            'headers' => [
                'Authorization' => $this->SAS,
            ]
        ]);

        return $response;
    }

    /**
     * Compute the Shared Access Signature token.
     *
     * @param string $resourceURI the Resource URI this SAS will apply to
     * @param string $key the secret key to use
     * @param string $expiry the expiry time in seconds from the epoch
     * @return string the full SAS token
     */
    function computeSAS($resourceURI, $key, $expiry)
    {
        $SAS = 'SharedAccessSignature ';

        $sr = strtolower(rawurlencode($resourceURI));
        $stringToSign = $sr . "\n" . $expiry;
        $hash = hash_hmac('sha256', $stringToSign, base64_decode($key), true);
        $sig = rawurlencode(base64_encode($hash));

        $SAS .= 'sr=' . $sr;
        $SAS .= '&sig=' . $sig;
        $SAS .= '&se=' . $expiry;

        return $SAS;
    }
}
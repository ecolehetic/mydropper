<?php

namespace APP\HELPERS;

class GoogleUrlApi extends BaseHelper
{

    private $apiUrl;
    private $googleUrl = "https://www.googleapis.com/urlshortener/v1/url";
    private $googleApiKey;

    // Constructor
    public function __construct()
    {
        parent::__construct();

        $this->googleApiKey = $this->f3->get('GOOGLE_API_KEY');

        $this->apiUrl = $this->googleUrl . '?key=' . $this->googleApiKey;
    }

    /**
     * Shorter URL with GoogleUrlShorter
     *
     * @param string $url
     *
     * @return bool|mixed
     */
    public function shorten($url)
    {
        $response = $this->send($url);

        return isset($response['id']) ? str_replace('http://', 'https://', $response['id']) : false;
    }

    /**
     * Expend URL with GoogleUrlShorter
     *
     * @param string $url
     *
     * @return bool
     */
    public function expand($url)
    {

        $response = $this->send($url, false);

        return isset($response['longUrl']) ? $response['longUrl'] : false;
    }

    /**
     * Watch Analytics with GoogleUrlShorter
     *
     * @param string $url
     *
     * @return bool
     */
    public function projection($url)
    {
        $response = $this->send($url, false, true);

        return isset($response['analytics']) ? $response['analytics'] : false;
    }

    /**
     * Seed informations to Google
     *
     * @param string $url
     * @param bool   $shorten
     * @param bool   $projection
     *
     *
     * @return mixed
     */
    private function send($url, $shorten = true, $projection = false)
    {
        // Create cURL
        $ch = curl_init();
        // If we're shortening a URL...
        if ($shorten) {
            curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array("longUrl" => $url)));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        } else {
            if ($projection === true) {
                curl_setopt($ch, CURLOPT_URL, $this->apiUrl . '&shortUrl=' . $url . '&projection=FULL');
            } else {
                curl_setopt($ch, CURLOPT_URL, $this->apiUrl . '&shortUrl=' . $url);
            }
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // Execute the post
        $result = curl_exec($ch);
        // Close the connection
        curl_close($ch);
        // Return the result
        return json_decode($result, true);
    }

}
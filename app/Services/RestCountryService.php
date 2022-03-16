<?php

namespace App\Services;

class RestCountryService
{
    private const URL = "https://restcountries.com/v3.1/region/";

    /**
     * @param string $region
     * @return array
     */
    public function getCountries(string $region) : array
    {
        // create & initialize a curl session
        $curl = curl_init();

        // set our url with curl_setopt()
        curl_setopt($curl, CURLOPT_URL, RestCountryService::URL . "$region");

        // return the transfer as a string, also with setopt()
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        // curl_exec() executes the started curl session
        $output = curl_exec($curl);

        // close curl resource to free up system resources
        // (deletes the variable made by curl_init)
        curl_close($curl);

        return json_decode($output, true);
    }
}

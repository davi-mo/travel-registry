<?php

namespace App\Services;

class RestCityService
{
    private const URL = "https://countriesnow.space/api/v0.1/countries";

    /**
     * @return array
     */
    public function getCities() : array
    {
        // create & initialize a curl session
        $curl = curl_init();

        // set our url with curl_setopt()
        curl_setopt($curl, CURLOPT_URL, RestCityService::URL);

        // return the transfer as a string, also with setopt()
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // set the header
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type' => 'application/json; charset=utf-8']);

        // curl_exec() executes the started curl session
        $output = curl_exec($curl);

        // close curl resource to free up system resources
        // (deletes the variable made by curl_init)
        curl_close($curl);

        return json_decode($output, true);
    }
}

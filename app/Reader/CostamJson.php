<?php
namespace Reader;
use Reader\ThirdParty as ThirdParty;


// concrete class
class CostamJson extends ThirdParty {


    private $client;

    function __construct($client) {

        $this->client = $client;
    }


    public function makeRequest($method, $element) {

        $apiResponse = $this->client->request($method, $element);
        $apiResponseJson = json_decode($apiResponse->getBody()->getContents(), true);

        return $apiResponseJson;
    }

    public function processResponse($apiResponse){

        // json processing
        // return array

        return 1;
    }


    public function saveResponse($phalconObject) {
        if ($phalconObject->save() === false) {
            echo "Umh, We can't store robots right now: \n";

            $messages = $phalconObject->getMessages();

            foreach ($messages as $message) {
                echo $message, "\n";
            }
        } else {
            echo "Great, a new robot was saved successfully!";
        }
    }
}


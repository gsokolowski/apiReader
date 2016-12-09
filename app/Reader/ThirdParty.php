<?php
namespace Reader;
use Reader\ThirdPartyInterface as ThirdPartyInterface;


abstract class ThirdParty implements ThirdPartyInterface {


    abstract public function makeRequest($method, $element); // make request to api to get data
    abstract public function processResponse($response);    //read xml and prepare to save to db
	abstract public function saveResponse($phalconObject);          //save xml response to db
}

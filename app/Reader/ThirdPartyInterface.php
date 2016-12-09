<?php
namespace Reader;

interface ThirdPartyInterface {
    public function makeRequest($method, $element);
    public function processResponse($response);
    public function saveResponse($phalconObject);
}

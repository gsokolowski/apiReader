<?php
// https://www.predic8.com/rest-demo.htm
// http://stackoverflow.com/questions/5757864/examples-of-rest-api-online
// https://api.github.com/users/mralexgray/repos  - json feed
// http://www.flickr.com/services/feeds/photos_public.gne?tags=soccer&format=json


use Reader\WilliamXml;
use Reader\CostamJson;

// to start server
// php -S localhost:8887

// Setup based on
// https://www.youtube.com/watch?v=VGSerlMoIrY

// load autoload to autoload all you classes in this project
require 'vendor/autoload.php';

// setup connection with db and prepare pdo to make queries
require 'bootstrap.php';


///////////////////////////////////
// Controller WilliamXml
///////////////////////////////////


// connect to Guzzle api
//$client = new GuzzleHttp\Client(['base_uri' => 'http://www.thomas-bayer.com']);
$client = new GuzzleHttp\Client(['base_uri' => 'http://cachepricefeeds.williamhill.com/']);



// dependency injection
$wiliam = new WilliamXml($client);

//$apiResponse = $wiliam->makeRequest('GET', '/sqlrest/CUSTOMER/18/');
$apiResponse = $wiliam->makeRequest('GET', 'openbet_cdn?action=template&template=getHierarchyByMarketType&classId=1&marketSort=HF&filterBIR=N');


$arr = $wiliam->processResponse($apiResponse);

print_r($arr);


// save on db
//$guzzleClient->save($robot);







///////////////////////////////////
// Controller WilliamJson
///////////////////////////////////


// connect to Guzzle api
$client = new GuzzleHttp\Client(['base_uri' => 'http://www.thomas-bayer.com']);

// dependency injection
$costam = new CostamJson($client);

$apiResponse = $costam->makeRequest('GET', '/sqlrest/CUSTOMER/18/');

$arr = $costam->processResponse($apiResponse);
var_dump($arr);


// save on db
//$guzzleClient->save($robot);


// for jason
// var_dump($arr[0]['origin']);







// I teraz w Phalconie to bedzie wygladalo tak
// Jeden model lub dwa do tabeli w DB oraz jeden controller
// ktory bedzie robil to co robi controller czyli wolal makeRequest() processResponse() i saveResponse()
// Interface is abstract class need to be in app/Reader a William xml class moze byc pod innym namespace
// i tak to zrobisz
//
// i repository gdzies trzeba wsadzic - tam beda te clasy z Reader
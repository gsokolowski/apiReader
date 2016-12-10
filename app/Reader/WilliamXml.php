<?php


// http://stackoverflow.com/questions/10740071/capture-data-from-xml-and-save-in-database
// http://stackoverflow.com/questions/8830599/php-convert-xml-to-json
// https://laracasts.com/discuss/channels/general-discussion/converting-xml-to-jsonarray


// save xml to database
// https://www.youtube.com/watch?v=uITycce6TvU
// https://www.youtube.com/watch?v=4ZLZkdiKGE0

namespace Reader;
use Reader\ThirdParty as ThirdParty;


// concrete class
class WilliamXml extends ThirdParty {


    private $client;

    function __construct($client) {

        $this->client = $client;
    }


    public function makeRequest($method, $element) {

        $apiResponse = $this->client->request($method, $element)->getBody()->getContents();

        return $apiResponse;
    }


    private function _xml2array ( $xmlObject, $out = array () )
    {
        foreach ( (array) $xmlObject as $index => $node )
            $out[$index] = ( is_object ( $node ) ) ? self::_xml2array( $node ) : $node;

        return $out;
    }

    // funkcje musisz zaimplementowac
    // ta funkja musi zwracasc dane w postaci tabeli
    // ta funkcja w CostamJason bedzie musiala rowniez zwracac dane w postaci tabli
    // zrobisz unifikacje

    public function processResponse($apiResponse){
        $responseXml = simplexml_load_string($apiResponse);


//
//        $array =  $this->_xml2array($responseXml);
//
//        echo count($array['@attributes']);
//        echo count($array['response']['@attributes']);
//        echo count($array['response']['williamhill']);
//
//
//        print_r($array['@attributes']);
//        print_r($array['response']['@attributes']);
//        print_r( $array['response']['williamhill']['class']['type'][0] );




        echo '<br/><br/><br/>';


        // Tak sie to robi - bardzo prosto wsadz ro w petle foreach i jedziesz

        $typeAtributes = $responseXml->response->williamhill->class->type[0]->attributes();
        $markerAtributes = $responseXml->response->williamhill->class->type[0]->market[0]->attributes();

        var_dump($typeAtributes);

        echo '<br/><br/><br/>';

        var_dump($markerAtributes);
        echo '<br/><br/><br/>';





        foreach($responseXml->xpath("response/williamhill/class/type/market/participant") as $item) {
            print_r($item);
            break;

        }



        echo '<br /><br />';

        $result = $responseXml->xpath("response/williamhill/class");

        //print_r($result);

        foreach($responseXml->xpath("response/williamhill/class") as $item) {
            $arr = $item->attributes();
            var_dump($arr);
            break;

        }




        // saving data to phalcone
        // najpierw wszystkie kategorie a poznie atrybuty , kazda kolumna to tabela w db
        // simplyfiy this by adding whole jsons to the rows

//        @attributes: {
//        name: "Draw/Draw",
//        id: "1403386209",
//        odds: "5/1",
//        oddsDecimal: "6.00",
//        lastUpdateDate: "2016-12-06",
//        lastUpdateTime: "08:43:53",
//        handicap: ""
//        }

//        use Store\Toys\Robots;
//
//        $robot = new Robots();
//
//        $robot->save(
//            [
//                "type" => "mechanical",
//                "name" => "Astro Boy",
//                "year" => 1952,
//            ]
//        );

//        example
//
//        foreach($element->xpath('//namespace:LINE_ITEMS/namespace:LINE_ITEM') as $item) {
//            $item->registerXPathNamespace('namespace', 'urn:foo');
//            var_dump((string)$item->xpath('.//namespace:PID[@type="erp_pid"]')[0]);
//        }

        //print_r($result);



        die();

        return $responseXml;



    }


    //https://docs.phalconphp.com/en/latest/reference/models.html#creating-updating-records
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
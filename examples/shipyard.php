<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16-7-31
 */

require_once __DIR__ . '/../vendor/autoload.php';

$settings = array(
    'base_url' => 'http://45.32.61.180:8080/',
);

//$shipyard = new Shipyard($settings);
$test = new \Dubuqingfeng\ShipyardAPI\Client\Shipyard($settings);
$get = $test->getAccounts();
//print_r($get);
print_r($test->getHost());
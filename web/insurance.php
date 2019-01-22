<?php

$client = new \SoapClient($wsdlUrl, $header);
$params = [];
$client->functionName($params);

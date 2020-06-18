<?php
header('Access-Control-Allow-Origin: *');
include("../config/Config.php");

$Url="https://ws.sandbox.pagseguro.uol.com.br/v2/sessions?email=".EMAIL_PAGSEGURO."&token=".TOKEN_SANDBOX."";
$Curl=curl_init($Url);
curl_setopt($Curl,CURLOPT_HTTPHEADER,array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
curl_setopt($Curl,CURLOPT_POST,1);
curl_setopt($Curl,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($Curl,CURLOPT_RETURNTRANSFER,true);
$Retorno=curl_exec($Curl);
curl_close($Curl);

$Xml=simplexml_load_string($Retorno);
echo json_encode($Xml);

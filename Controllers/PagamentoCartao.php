<?php
header('Access-Control-Allow-Origin: *');
include("../config/Config.php");

$Products=json_decode($_POST['Products']);
$TokenCard=$_POST['TokenCard'];
$HashCard=$_POST['HashCard'];
$QtdParcelas=filter_input(INPUT_POST, 'QtdParcelas', FILTER_SANITIZE_SPECIAL_CHARS);
$ValorParcelas=filter_input(INPUT_POST, 'ValorParcelas', FILTER_SANITIZE_SPECIAL_CHARS);

$CPFCartao=filter_input(INPUT_POST, 'CPFCartao', FILTER_SANITIZE_SPECIAL_CHARS);
$NomeComprador=filter_input(INPUT_POST, 'NomeComprador', FILTER_SANITIZE_SPECIAL_CHARS);
$CPFComprador=filter_input(INPUT_POST, 'CPFComprador', FILTER_SANITIZE_SPECIAL_CHARS);
$DDDComprador=filter_input(INPUT_POST, 'DDDComprador', FILTER_SANITIZE_SPECIAL_CHARS);
$TelefoneComprador=filter_input(INPUT_POST, 'TelefoneComprador', FILTER_SANITIZE_SPECIAL_CHARS);
$NomeCartao=filter_input(INPUT_POST, 'NomeCartao', FILTER_SANITIZE_SPECIAL_CHARS);
$Endereco=filter_input(INPUT_POST, 'Endereco', FILTER_SANITIZE_SPECIAL_CHARS);
$Numero=filter_input(INPUT_POST, 'Numero', FILTER_SANITIZE_SPECIAL_CHARS);
$Complemento=filter_input(INPUT_POST, 'Complemento', FILTER_SANITIZE_SPECIAL_CHARS);
$Bairro=filter_input(INPUT_POST, 'Bairro', FILTER_SANITIZE_SPECIAL_CHARS);
$Cidade=filter_input(INPUT_POST, 'Cidade', FILTER_SANITIZE_SPECIAL_CHARS);
$UF=filter_input(INPUT_POST, 'UF', FILTER_SANITIZE_SPECIAL_CHARS);
$CEP=filter_input(INPUT_POST, 'CEP', FILTER_SANITIZE_SPECIAL_CHARS);

$Data["email"]=EMAIL_PAGSEGURO;
$Data["token"]=TOKEN_SANDBOX;
$Data["paymentMode"]="default";
$Data["paymentMethod"]="creditCard";
$Data["receiverEmail"]=EMAIL_PAGSEGURO;
$Data["currency"]="BRL";

foreach ($Products as $key=>$Product) {
    $i = $key + 1;
    $Data["itemId{$i}"] = $Product->id;
    $Data["itemDescription{$i}"] = $Product->Descricao;
    $Data["itemAmount{$i}"] = $Product->Valor;
    $Data["itemQuantity{$i}"] = $Product->Quantidade;
}

// $Data["itemId1"] = 1;
// $Data["itemDescription1"] = 'EXEMPLO';
// $Data["itemAmount1"] = '250.00';
// $Data["itemQuantity1"] = 1;

$Data["notificationURL="]="https://www.meusite.com.br/notificacao.php";
$Data["reference"]="83783783737";
$Data["senderName"]=$NomeComprador;
$Data["senderCPF"]=$CPFComprador;
$Data["senderAreaCode"]=$DDDComprador;
$Data["senderPhone"]=$TelefoneComprador;
$Data["senderEmail"]="SENDER E-MAIL AQUI";
$Data["senderHash"]=$HashCard;
$Data["shippingType"]="1";
$Data["shippingAddressStreet"]=$Endereco;
$Data["shippingAddressNumber"]=$Numero;
$Data["shippingAddressComplement"]=$Complemento;
$Data["shippingAddressDistrict"]=$Bairro;
$Data["shippingAddressPostalCode"]=$CEP;
$Data["shippingAddressCity"]=$Cidade;
$Data["shippingAddressState"]=$UF;
$Data["shippingAddressCountry"]="BRA";
$Data["shippingType"]="1";
$Data["shippingCost"]="0.00";
$Data["creditCardToken"]=$TokenCard;
$Data["installmentQuantity"]=$QtdParcelas;
$Data["installmentValue"]=$ValorParcelas;
$Data["noInterestInstallmentQuantity"]=2;
$Data["creditCardHolderName"]=$NomeCartao;
$Data["creditCardHolderCPF"]=$CPFCartao;
$Data["creditCardHolderBirthDate"]='27/10/1987';
$Data["creditCardHolderAreaCode"]=$DDDComprador;
$Data["creditCardHolderPhone"]=$TelefoneComprador;
$Data["billingAddressStreet"]=$Endereco;
$Data["billingAddressNumber"]=$Numero;
$Data["billingAddressComplement"]=$Complemento;
$Data["billingAddressDistrict"]=$Bairro;
$Data["billingAddressPostalCode"]=$CEP;
$Data["billingAddressCity"]=$Cidade;
$Data["billingAddressState"]=$UF;
$Data["billingAddressCountry"]="BRA";

$BuildQuery=http_build_query($Data);
$Url="https://ws.sandbox.pagseguro.uol.com.br/v2/transactions";

$Curl=curl_init($Url);
curl_setopt($Curl, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
curl_setopt($Curl, CURLOPT_POST, true);
curl_setopt($Curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($Curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($Curl, CURLOPT_POSTFIELDS, $BuildQuery);
$Retorno=curl_exec($Curl);
curl_close($Curl);

$Xml=simplexml_load_string($Retorno);
var_dump($Xml);

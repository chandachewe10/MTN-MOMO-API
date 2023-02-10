<?php

if($_SERVER['REQUEST_METHOD']=="POST"){

//Require XreferenceId for collections and making api user
require 'xReferenceID1.php';
require 'xReferenceID2.php';

// SET CREDENTIALS

//X-reference-ID generated automatically
$xReferenceId=$UUID;
$xReferenceId=$UUID;
$xReferenceId=$UUID; 

//Subscription Key from MTN MoMo Sandbox
$subscriptionKey="****************************************"; 

//Provider Callbackhost....You Can Change This as You Wish
$providerCallbackHost="webhook.site"; 

//Callbackhost URL....You Can Change This as You Wish
$XCallbackUrl="http://webhook.site/e9ea613b-5ecb-4cd2-bb1b-eedb6d9557a6"; 



// CREATE THE API USER
//Initialising the clientURL session for sending & recieving requests In PHP
$apiUser = curl_init();

curl_setopt_array($apiUser, array(
  CURLOPT_URL => 'https://sandbox.momodeveloper.mtn.com/v1_0/apiuser',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
  "providerCallbackHost": '.json_encode($providerCallbackHost).'
}',
  CURLOPT_HTTPHEADER => array(
    'X-Reference-Id: '.$xReferenceId,
    'Ocp-Apim-Subscription-Key: '.$subscriptionKey,
    'Content-Type: application/json'
  ),
  CURLOPT_SSL_VERIFYPEER => FALSE,
  CURLOPT_SSL_VERIFYHOST => FALSE,
));

$response = curl_exec($apiUser);


//Close clientURL session for creating APIUSER
curl_close($apiUser);



//CREATING THE APIKEY
//Create cURL Session for creating apikey 
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://sandbox.momodeveloper.mtn.com/v1_0/apiuser/'.$xReferenceId.'/apikey',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',  
  CURLOPT_HTTPHEADER => array(
    'X-Reference-Id:'.$xReferenceId,
    'Ocp-Apim-Subscription-Key:'.$subscriptionKey,
    'Content-Length:0',
  ),
  CURLOPT_SSL_VERIFYPEER => FALSE,
  CURLOPT_SSL_VERIFYHOST => FALSE,
));

$API = curl_exec($curl);
$removeCurlyBraces= substr($API, 1, -1);
$string = explode(':', $removeCurlyBraces);
//APIKEY Without curly braces
$apiKey=$string[1];
//APIKEY Without Quotes
$password =trim($apiKey,'"');

//Close cURL Session for making APIKEY
curl_close($curl);





//CREATING ACCESS TOKEN (BEARER TOKEN) FROM APIKEY AND X-REFERENCE-ID
//WE USE BASIC AUTH WERE X-REFERENCE-ID IS USERNAME AND APIKEY IS PASSWORD


$Token = curl_init();

curl_setopt_array($Token, array(
  CURLOPT_URL => 'https://sandbox.momodeveloper.mtn.com/collection/token/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_USERAGENT=>'Mozilla/5.0 (platform; rv:geckoversion) Gecko/geckotrail Firefox/firefoxversion',
  CURLOPT_CUSTOMREQUEST => 'POST',
   CURLOPT_HTTPHEADER => array(
    'Ocp-Apim-Subscription-Key: '.$subscriptionKey,
    'Content-Length:0',
    'Authorization: Basic ' . base64_encode($xReferenceId . ':' .$password)
  ),
  CURLOPT_SSL_VERIFYPEER => FALSE,
  CURLOPT_SSL_VERIFYHOST => FALSE,
));

$BearerToken = substr(curl_exec($Token),1,-1);
$Bearer = explode(':', $BearerToken);
$token=$Bearer[1];
$Bear = explode(',', $token);
$TokenSanitized=substr($Bear[0],1,-1);


//Close cURL Session for making BearerToken
curl_close($Token);




//PAYMENT REQUEST FROM A CUSTOMER
//Open cURL Session for requesting payment from a customer
$PaymentRequest = curl_init();
$amount=$_POST['amount'];
$phone=$_POST['phone'];
$ref=$_POST['referenceNumber'];

curl_setopt_array($PaymentRequest, array(

  CURLOPT_URL => 'https://sandbox.momodeveloper.mtn.com/collection/v1_0/requesttopay',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
  "amount": '.json_encode($amount).',
  "currency": "EUR",
  "externalId": '.json_encode($ref).',
  "payer": {
    "partyIdType": "MSISDN",
    "partyId": '.json_encode($phone).'
  },
  "payerMessage": "Paying For a Novel",
  "payeeNote": "Payment Successfull"
}',
  CURLOPT_HTTPHEADER => array(
    'X-Reference-Id: '.$UUIDPayment,
    'X-Target-Environment: sandbox',
    'Content-Type: application/json',
    'Ocp-Apim-Subscription-Key: '.$subscriptionKey,
    'X-Callback-Url:'.$XCallbackUrl,
    'Authorization: Bearer '.$TokenSanitized
  ),
  CURLOPT_SSL_VERIFYPEER => FALSE,
  CURLOPT_SSL_VERIFYHOST => FALSE,
));

$response = curl_exec($PaymentRequest);
echo "Payment Successfull : $response.<br>";

//Close cURL Session for making Payment From A customer
curl_close($PaymentRequest);





//GETTING THE STATUS OF PAYMENT WHETHER IT WAS SUCCESSFULL OR NOT 
//Open cURL Session for status payment from a customer
$PaymentStatus = curl_init();

curl_setopt_array($PaymentStatus, array(
  CURLOPT_URL => 'https://sandbox.momodeveloper.mtn.com/collection/v1_0/requesttopay/'.$UUIDPayment,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'X-Target-Environment: sandbox',
    'Ocp-Apim-Subscription-Key: '.$subscriptionKey,
    'Authorization: Bearer '.$TokenSanitized
  ),
  CURLOPT_SSL_VERIFYPEER => FALSE,
  CURLOPT_SSL_VERIFYHOST => FALSE,
));

$response = curl_exec($PaymentStatus);

echo $response;
//Close cURL Session for status Payment From A customer
curl_close($PaymentStatus);

}

?>



<!-- INITIALISNG PAYMENT FROM A CUSTOMER FROM CLIENT SIDE-->

<!DOCTYPE html>

<head>
    <title>MTN MOMO API</title>
    <meta charset="utf-8" />
    <meta name="developer" content="Chanda Chewe" />
    <meta name="description" content="MTN MoMoAPI Client Side" />
    <meta name="revised" content="16/09/2021" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
<!-- style css -->
<link rel="stylesheet" type="text/css" href="Assets/MoMoAPICss.css">
  </head>

<body>
    <center>
      
        
  <form action="<?PHP echo ($_SERVER['PHP_SELF']); ?>";  method="POST">
    <h3>MTN MOMO API</h3>
    <h4>COLLECTIONS</h4>
        <input type="number" name="amount" id="name" placeholder="Enter Amount" ></br>
        <input type="number" name="phone" id="name" placeholder="Enter phone number"></br>
        <input type="number" name="referenceNumber" id="name" placeholder="Enter Reference Number"></br>
        <input type="submit" value="ZMW" id="upload">
        <br><br>
        
        </form>
        <!--notes-->
        <small style="color:blue">For Further inquiries contact whatever@whatever.com</small>
      
    </center>
    
        
</body>
</html>


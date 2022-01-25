<?php
// UUID (X-REFERENCE) For Requesting Payments
$PaymentRequestUUID = curl_init();

curl_setopt_array($PaymentRequestUUID, array(
  CURLOPT_URL => 'https://www.uuidgenerator.net/api/version4',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_USERAGENT=>'Mozilla/5.0 (platform; rv:geckoversion) Gecko/geckotrail Firefox/firefoxversion',
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_SSL_VERIFYPEER => FALSE,
  CURLOPT_SSL_VERIFYHOST => FALSE,
));

$UUIDPayment = curl_exec($PaymentRequestUUID);


curl_close($PaymentRequestUUID);
?>
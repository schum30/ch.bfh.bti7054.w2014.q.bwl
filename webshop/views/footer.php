<footer>
<?php
$service_url = 'http://api.adviceslip.com/advice';
$curl = curl_init($service_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$curl_response = curl_exec($curl);
curl_close($curl);

$decoded = json_decode($curl_response);
echo $decoded->slip->advice;
?>
</footer>

<?php

$url = 'https://stackexchange.com/oauth/access_token';
$params = [
    'client_id' => 26384,
    'client_secret' => 'vPVZ*DTLlYmwu4tN)U*8ag((',
    'code' => 'Nrj1O9MV36jstRxNGoXByQ))',
    'redirect_uri' => 'localhost'
];
$params = http_build_query($params);

$headers = [
    'Content-Type: application/x-www-form-urlencoded'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

echo $status_code . "\n";
echo $response;
?>

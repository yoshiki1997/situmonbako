<?php

$url = "https://stackexchange.com/oauth/access_token";
$client_id = 26384;
$client_secret = "vPVZ*DTLlYmwu4tN)U*8ag((";
$code = "bR9fBZI2byHLW4FqKRkDuw))";
$redirect_uri = "http://localhost:80/";

$data = array(
    "client_id" => $client_id,
    "client_secret" => $client_secret,
    "code" => $code,
    "redirect_uri" => $redirect_uri
    
);

$options = array(
    "http" => array(
        "header" => "Content-type: application/x-www-form-urlencoded",
        "method" => "POST",
        "content" => http_build_query($data)
    )
);

$context = stream_context_create($options);
//var_dump(file_get_contents($url, false, $context));
$response = file_get_contents($url, false, $context);

/*$data_string = http_build_query($data);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);*/

$access_token = $response;

// Access Token の情報を表示
echo $access_token;

?>

<?php

// We got the access code flag so we will make a new request to get the access token
$fields = array(
    'client_id' => $client_id,
    'client_secret' => $client_secret,
    'grant_type' => 'authorization_code',
    'redirect_uri' => $redirect_uri,
    'scope' => 'profile',
    'code' => $auth_code,
);
$postData = data_encode($fields);
$ch = curl_init($token_endpoint);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$resonse = curl_exec($ch);
curl_close($ch);
$result = json_decode($resonse);

if (isset($result->error)) {
    // We got an error
// values
//    $result->error;
//    $result->error_description;
    $error = $result->error;
    $error_description = $result->error_description;
} elseif (isset($result->access_token) && isset($result->refresh_token) && isset($result->scope)) {
    // Successful response
// values
//    $result->access_token;
//    $result->expires_in;
//    $result->token_type;
//    $result->scope;
//    $result->refresh_token;
    // Use this to request data from the server
    $accessToken = $result->access_token; //TODO: Store this token and use it if need to make a new request. Note the "expires in"
    // Use this to request a new access token
    $refreshToken = $result->refresh_token; //TODO: Store this token and use it if needed to get a new access token if the last one has expired
    // This is the default scope, multiple scopes are separated by a single space
    $scope = $result->scope;
    // Here we can save the access token and redirect the user to desired page
} else {
    // Unknown
}

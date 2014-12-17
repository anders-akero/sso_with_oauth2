<?php
// http://tools.ietf.org/html/rfc6749#section-4.1.1
// OAuth settings
static $client_state = '100100,34566';
static $client_id = 'clientid';
static $client_secret = '099bd09076d016d1b29109e21ca9764ca23bd0b0e92c973c2256519b195e92f7';
// redirect_uri
static $redirect_uri = 'http://localhost/oauth2client';
// Endpoint strings
static $token_endpoint = 'http://localhost/oauth2server/token.php';
static $authorize_endpoint = 'http://localhost/oauth2server/authorize.php';
static $resource_endpoint = 'http://localhost/oauth2server/resource.php';

// Fetch the "Authentication Code" from the GET params
$auth_code = isset($_GET['code']) ? $_GET['code'] : null;
$error = isset($_GET['error']) ? $_GET['error'] : null;
$error_description = isset($_GET['error_description']) ? $_GET['error_description'] : null;

/**
 * urlencodes a multidimentional array
 * call this function like data_encode(array('key'=>'value'));
 * @param array $data, data to be encoded
 * @param string $keyprefix, used internal of this function
 * @param string $keypostfix, used internal of this function
 * @return string
 */
function data_encode($data, $keyprefix = '', $keypostfix = '')
{
    assert(is_array($data));
    $vars = null;
    foreach ($data as $key => $value) {
        if (is_array($value))
            $vars .= data_encode($value, $keyprefix . $key . $keypostfix . urlencode('['), urlencode(']'));
        else
            $vars .= $keyprefix . $key . $keypostfix . '=' . urlencode($value) . '&';
    }
    return $vars;
}

/**
 * Makes a request to the server
 * @param string $accessToken
 * @param string $scope
 * @return std object
 */
function getResource($accessToken, $scope = 'profile')
{
    $fields = array(
        'scope' => $scope,
        'access_token' => $accessToken,
    );
    $postData = data_encode($fields);
    global $resource_endpoint;
    $ch = curl_init($resource_endpoint);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $resonse = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($resonse);
    return $result;
}

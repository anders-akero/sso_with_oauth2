<?php

// include our OAuth2 Server object
require_once __DIR__ . '/server.php';

// Handle a request for an OAuth2.0 Access Token and send the response to the client
$request = OAuth2\Request::createFromGlobals();
$response = new OAuth2\Response();
$scope = $scopeUtil->getScopeFromRequest($request);
if (!$server->verifyResourceRequest($request, $response, $scope)) {
    $server->getResponse()->send();
    die;
}

$access_token = isset($_POST['access_token']) ? $_POST['access_token'] : NULL;
if (!$access_token) {
    echo '{"error": "Missing access token"}';
    die;
}
switch($scope){
    case 'profile':
        require_once 'scope_profile.php';
        break;
    case 'basic':
        echo '{"error": "scope email was requested"}';
        break;
    default:
        echo '{"error": "Unknown scope"}';
}

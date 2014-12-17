<?php
// include our OAuth2 Server object
require_once 'server.php';

$request = OAuth2\Request::createFromGlobals();
$response = new OAuth2\Response();
$error = null;

// let the OAuth library validate the authorize request
if (!$server->validateAuthorizeRequest($request, $response)) {
    $response->send();
    die();
}

if (!empty($_POST)) {
    // Try to log in the user
    $is_authorized = false;
    if ((bool) $_POST['login']) {
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $data = array('username' => $username, 'password' => $password);

        $stmt = $dbconnection->prepare(sprintf('SELECT * from oauth_users where username = :username AND password = :password'));
        $stmt->execute($data);
//        $stmt->execute(compact('client_id'));
        while ($row = $stmt->fetch()) {
            $is_authorized = true;
        }

        if ($is_authorized) {
            $server->handleAuthorizeRequest($request, $response, $is_authorized, $_POST['username']);
            $response->send();
            die();
        } else {
            $error = 'Invalid password or username';
        }
    } elseif ((bool) $_POST['cancel']) {
        $is_authorized = false;
        $server->handleAuthorizeRequest($request, $response, $is_authorized, $_POST['username']);
        $response->send();
    }
}
require_once 'login.php';

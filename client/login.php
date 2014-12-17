<?php
// File on the client side to be redirect the user to the login page on the server
?>
<h1>Login page, Client side</h1>

<a href="<?= $authorize_endpoint ?>?
   response_type=code&
   client_id=<?= $client_id ?>&
   state=<?= $client_state; ?>&
   redirect_uri=<?= $redirect_uri; ?>
   ">
    Login
</a>

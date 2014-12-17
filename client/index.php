<!DOCTYPE html>
<html>
    <body>

        <?php
        require_once 'config.php';
        if ($auth_code) {
            require_once 'token.php';
        } else {
            require_once 'login.php';
        }
        if ($error) {
            // Note that this can be as simple as the user clicked Cancel on the login page and thus refused access
            // If you want to show these errors to the user you should look at the value in $error and not the value in $error_description
            // and then write your own user friendly error message.
            echo '<b>Error: </b>';
            if ($error_description) {
                echo ': ' . $error_description;
            }
        }

        // This is just here to show how you can get data from the server once you have an access token
        if ($accessToken && $scope) {
            // Following is how you can get data from the oauth server when you have a access token.
            // Note that an access token may expire
            $result = getResource($accessToken, $scope);
            var_dump($result);
        }
        // This is just here as a helper to start over again
        if ($auth_code) {
            echo '<p><a href=".">Start Over</a></p>';
        }
        ?>

    </body>
</html>

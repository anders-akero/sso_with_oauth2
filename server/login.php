<!DOCTYPE html>
<html>
    <body class="container">

        <h1>Login Page</h1>

        <form method="post">
            <label>Username: <br><input type="text" name="username"></label>
            <br>
            <label>Password: <br><input type="password" name="password"></label>
            <br />
            <input type="submit" name="login" value="Login">
            <input type="submit" name="cancel" value="Cancel">
            <?= $error ?>
        </form>
    </body>
</html>

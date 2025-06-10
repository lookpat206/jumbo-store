<?php
session_start();


if (isset($_SESSION['msg_err'])) {
    $msg_err = $_SESSION['msg_err'];
} else {
    $msg_err = "";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>

    <link rel="stylesheet" href="../_asset/css/style.css

">

</head>

<body>
    <div class="login-page">
        <div class="form">
            <form class="login-form" action="login_check.php" method="POST">
                <input type="text" name="name" placeholder="username" />
                <input type="password" name="pass" placeholder="password" />

                <h4 style="color:red;"><?= $msg_err ?></h4>

                <button type="submit">login</button>
                <p class="message">Not registered? <a href="#">Create an account</a></p>
            </form>
        </div>
    </div>
</body>

</html>
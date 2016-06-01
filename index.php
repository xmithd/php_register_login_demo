<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Welcome to AuthentApp</title>
</head>
<body>
<?php
require_once 'services/LoginService.php';
require_once 'services/ServiceLocator.php';
// define variables and set to empty values
function test_input($data) {
    if (isset($data)) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    } else {
        return '';
    }
}

function showLoginForm() {
    $action = htmlspecialchars($_SERVER['PHP_SELF']);
    echo '
    <h1>Please log in.</h1>
<form action="'. $action . '" method="post">
    <label>E-mail: </label><input type="text" name="email"/><br>
    <label>Password: </label><input type="password" name="password"/><br />
    <input type="submit" value="Submit"/>
</form>
<p>No Account yet? Register <a href="/register">here</a>.</p>
    ';
}

function showWelcome() {
    echo '<h1>Welcome!</h1>';
    echo '<p>There is nothing here yet... Not even a session!</p>';
    echo '<p><a href="/">Go back to the login page</a></p>';
}
$errmsg = "";
$name = $email = $pwd = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email'])? test_input($_POST["email"]) : '';
    $pwd = $_POST['password'];
    if (!empty($email) && !empty($pwd)) {
        //$pwd = password_hash($pwd, PASSWORD_BCRYPT);
        $loginService = ServiceLocator::getLoginService();
        $token = $loginService->validateUsernamePassword($email, $pwd);
        if ($token) {
            showWelcome();
        } else {
            echo 'username/password mismatch!';
            showLoginForm();
        }
    } else {
        echo 'Missing fields';
        showLoginForm();
    }
} else {
    showLoginForm();
}
?>
</body>
</html>
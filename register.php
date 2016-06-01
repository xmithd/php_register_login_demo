<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Register to this (not so awesome) website.</title>
</head>
<body>
<?php
require_once __DIR__.'/services/ServiceLocator.php';
require_once __DIR__.'/services/LoginService.php';

function showThankYouMessage() {
    echo '
<section>
        Thank you for registering! <br />
        You may now login <br />
</section>';
}
// define variables and set to empty values
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function showForm() {
    $action = htmlspecialchars($_SERVER['PHP_SELF']);
   echo '
<h1>Enter the details below</h1>
<form action="'. $action .'" method="post">
    <label>Name: </label><input type="text" name="name"/><br>
    <label>E-mail: </label><input type="text" name="email"/><br>
    <p>Please select a password. <br /></p>
    <label>Password: </label><input type="password" name="password"/><br />
    <label>Re-enter the password: </label><input type="password" name="password2"/><br />
    <input type="submit" value="Submit"/>
</form>
   '; 
}

$name = $email = $pwd = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $pwd = $_POST["password"];
    $pwd2 = $_POST["password2"];
    if (!empty($name) && !empty($email) && !empty($pwd) && !empty($pwd2)) {
        if (strcmp($pwd, $pwd2) != 0) {
            echo "Passwords don't match";
            showForm();
        } else {
            // register service
            $loginService = ServiceLocator::getLoginService();
            $entity = $loginService->createUser($email, $name, $pwd);
            if ($entity) {
                echo 'Your user is ' . $entity->toJson();
                showThankYouMessage();
            } else {
                echo 'An error occurred';
                showForm();
            }
        }
    } else {
        echo 'Missing information';
        showForm();
    }
} else {
    showForm();
}

?>

</body>
</html>
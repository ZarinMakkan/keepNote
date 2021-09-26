<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    $query = new MongoDB\Driver\Query([]);
    $rows = $manager->executeQuery('keepNote.users', $query);
    $flagForExistInDataBase = false;
    foreach ($rows as $row) {
        if($row->userName == $_POST['userName'] && $row->passWord == $_POST['passWord']) {
            $flagForExistInDataBase = true;
            session_start();
            $_SESSION["userName"] = $row->userName;
            $_SESSION["passWord"] = $row->passWord;
            header("Location:/mingo/importantProject.php");
            exit;
        }
    }
    if($flagForExistInDataBase == false) {
        echo "rejected";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login^_^</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="./log.css?v=<?php echo time(); ?>" />
    </head>
    <body>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">

            <div class="container">
                <h1>Login</h1>
                <p>Please fill in this form to Login your account.</p>
                <hr>

                <label for="userName">User Name</label>
                <input name="userName" placeholder="Enter User Name" type="text" id="userName" required/><br>
                <label for="passWord">Password</label>
                <input name="passWord" type="password" placeholder="Enter Password" id="passWord" required/><br>

                <hr>
                <input type="submit" class="registerbtn" value="login"/>
            </div>

            <div class="container signin">
                <p>Don't have an account? <a href="register.php">Register</a>.</p>
            </div>
        </form>
    </body>
</html>
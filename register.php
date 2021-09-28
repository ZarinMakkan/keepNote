<?php
$flag = false;
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if($_POST['passWord'] == $_POST['passWordAgain']) {
        $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->insert(['userName' => $_POST['userName'], 'passWord' => $_POST['passWord']]);
        $manager->executeBulkWrite('keepNote.users', $bulk);
        echo "Secsessful Register" . "<br>" . "Please login using the link at the bottom of the page";
        $flag = true;
    }
    else{
        echo "rejected";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Register^_^</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="./login.css?v=<?php echo time(); ?>" />
    </head>
    <body>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <div class="container">
                <h1>Register</h1>
                <p>Please fill in this form to create an account.</p>
                <hr>

                <label for="userName">User Name</label>
                <input name="userName" placeholder="Enter User Name" type="text" id="userName" required/><br>
                <label for="passWord">Password</label>
                <input name="passWord" type="password" placeholder="Enter Password" id="passWord" required/><br>
                <label for="passWordAgain">Password Again</label>
                <input name="passWordAgain" type="password" placeholder="Enter Password Again" id="passWordAgain" required/><br>

                <hr>
                <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
                <input type="submit" class="registerbtn" value="register"/>
            </div>
            <div class="container signin">
                <p>Already have an account? <a href="loginPage.php">Sign in</a>.</p>
            </div>
        </form>
        <?php
            if($flag) {
            ?>
                <form action="loginPage.php">
                    <input type="submit" class="registerbtn" value="login"/>
                </form>
            <?php
            }
            ?>
    </body>
</html>
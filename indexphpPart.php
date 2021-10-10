<?php
session_start();
if (empty($_SESSION['userName'])) {
    header("Location:loginPage.php");
    exit;
}
$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
if (!empty($_POST)) {
    if (!empty($_POST["task_id"])) {
        $taskID = $_POST["task_id"];
        echo $taskID;
    }
    if (!empty($_POST["mainText"])) {
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->insert(['text' => $_POST["mainText"], 'done' => false, 'user' => $_SESSION["userName"]]);
        $manager->executeBulkWrite('keepNote.task', $bulk);
    }

    if (!empty($_POST["status"])) {
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->update(['_id' => new \MongoDB\BSON\ObjectID($taskID), 'user' => $_SESSION["userName"]], [
            '$set' => [
                'done' => $_POST["status"] == 'done' ? true : false
            ]
        ]);
        $manager->executeBulkWrite('keepNote.task', $bulk);
    }
    if (!empty($_POST["delete"])) {
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->delete(['_id' => new \MongoDB\BSON\ObjectID($taskID), 'user' => $_SESSION["userName"]]);
        $manager->executeBulkWrite('keepNote.task', $bulk);
    }
    if (!empty($_POST['collabedName'])) {
        $collabFindUserQ = new MongoDB\Driver\Query(['userName' => $_POST['collabedName']]);
        $existUser = $manager->executeQuery('keepNote.users', $collabFindUserQ)->toArray();
        if (empty($existUser)) {
            echo '<script type="text/JavaScript"> 
                alert("User Not Found!");
                </script>';
        } else {
            $findTaskName = new MongoDB\Driver\Query(['_id' => new \MongoDB\BSON\ObjectID($_POST['taskColledID'])]);
            $foundedTask = $manager->executeQuery('keepNote.task', $findTaskName)->toArray();

            $bulk = new MongoDB\Driver\BulkWrite;
            $bulk->insert(['text' => $foundedTask[0]->text, 'done' => false, 'user' => $existUser[0]->userName]);
            $manager->executeBulkWrite('keepNote.task', $bulk);
            echo '<script type="text/JavaScript"> 
                alert("Secsessful Collaborate!");
                </script>';
        }
    }
    if (!empty($_POST['logout'])) {
        session_destroy();
    }
    header("refresh: 0");
}
$query = new MongoDB\Driver\Query(['user' => $_SESSION["userName"]]);
$rows = $manager->executeQuery('keepNote.task', $query);
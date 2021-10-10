<?php
session_start();
if (empty($_SESSION['userName'])) {
    header("Location:loginPage.php");
    exit;
}
var_dump($_POST);
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

?>
<!DOCTYPE html>
<html>

<head>
    <title>Keep Note For You!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./main.css?v=<?php echo time(); ?>" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>

    <!-- this is a modal for collabPage; -->
    <div id="modal">
        <div id="modal-content">
            <form action="index.php" method="POST">
                <input type="hidden" name="taskColledID" id="taskColledID" />
                <input type="text" name="collabedName" id="collabInput" placeholder="اسم دوستتو که میخای اینکارو باهاش بکنی رو زود بزن" />
                <input type="submit" value="ok" id="closeSubmitmodal" />
            </form>
        </div>
    </div>
    <!-- end collaborate modal -->

    <div id="myDIV" class="header">
        <span><input type="submit" onclick="logout()" id="logOut" value="log out"></span>
        <h2><?php echo $_SESSION['userName']; ?> To Do List</h2>
        <form action="index.php" method="POST">
            <input name="mainText" type="text" id="myInput" placeholder="what do you want to do? . . .">
            <input type="submit" onclick="window.location.href=window.location.href" class="addBtn" value="add">
        </form>
    </div>

    <ul id="myUL">
        <?php
        foreach ($rows as $row) {
        ?>

            <form action="index.php" method="POST">
                <li>
                    <input type="hidden" name="task_id" value="<?php echo $row->_id; ?>" />
                    <input class="checkbox" type="checkbox" id="task_<?php echo $row->_id; ?>" onclick="toChangeTick('<?php echo $row->_id; ?>')" <?php if ($row->done == true) {
                                                                                                                                                        echo 'checked';
                                                                                                                                                    } ?> />

                    <input type="text" value="<?php echo $row->text; ?>" />

                    <input class="btnCheckbox" name="delete" type="submit" value="Delete" />

                    <input class="btnCollabClick" id="<?php echo $row->_id; ?>" type="button" value="Collaborate">
                </li>
            </form>
        <?php } ?>
    </ul>

</body>

</html>

<script type="text/javascript">
    function toChangeTick(id) {
        var status = 'todo';
        if ($("#task_" + id).prop('checked') == true) {
            status = 'done';
        }
        $.ajax({
            type: "POST",
            url: window.location.href,
            data: {
                status: status,
                task_id: id
            }, // serializes the form's elements.
            success: function(data) {
                location.reload();
            }
        });
    }

    function logout() {
        $.ajax({
            type: "POST",
            url: window.location.href,
            data: {
                logout: 'yes'
            },
            success: function() {
                location.reload();
            }
        });

    }
    //about collaborate modal
    var modal = document.getElementById("modal");
    var collabBtns = document.getElementsByClassName("btnCollabClick");
    var closeModal = document.getElementById("closeSubmitmodal");
    var idTaskCollabshode;

    for (let i = 0; i < collabBtns.length; i++) {
        collabBtns[i].onclick = function() {
            modal.style.display = "block";
            idTaskCollabshode = collabBtns[i].getAttribute('id');
        }
    }

    closeModal.onclick = function() {
        var taskColledID = document.getElementById("taskColledID");
        taskColledID.value = idTaskCollabshode;
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    ////////////////////////////
</script>
<?php
var_dump($_POST);
session_start();
if(empty($_SESSION['userName'])) {
    header("Location:loginPage.php");
    exit;
}

$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
if(!empty($_POST["workToDo"])) {
    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk->insert(['text' => $_POST["workToDo"], 'done' => false, 'user' => $_SESSION["userName"]]);
    $manager->executeBulkWrite('keepNote.task', $bulk);
}
if(!empty($_POST["status"])) {
    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk->update(['_id' => new \MongoDB\BSON\ObjectID($_POST["task_id"]),'user' => $_SESSION["userName"]], [
        '$set' => [
            'done' => $_POST["status"] == 'done' ? true : false
        ]
    ]);
    $manager->executeBulkWrite('keepNote.task', $bulk);
}
if(!empty($_POST["done"])) {
    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk->update(['_id' => $_POST["task_id"], 'done' => false, 'user' => $_SESSION["userName"]], ['$set' => ['done' => true]]);
    $manager->executeBulkWrite('keepNote.task', $bulk);
}
if(!empty($_POST["delete"])) {
    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk->delete(['_id' => $_POST["task_id"], 'user' => $_SESSION["userName"]]);
    $manager->executeBulkWrite('keepNote.task', $bulk);
}
$query = new MongoDB\Driver\Query(['user' => $_SESSION["userName"]]);
$rows = $manager->executeQuery('keepNote.task', $query);

if(!empty($_POST['theField'])) {
    $collabFindUserQ = new MongoDB\Driver\Query(['userName' => $_POST['theField']]);
    $existUser = $manager->executeQuery('keepNote.users', $collabFindUserQ)->toArray();
    if(empty($existUser)) {
        echo '<script type="text/JavaScript"> 
            alert("User Not Found!");
            </script>'
        ;
    }
    else{
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->insert(['text' => $_POST["nameText"], 'done' => false, 'user' => $existUser[0]->userName]);
        $manager->executeBulkWrite('keepNote.task', $bulk);
        echo '<script type="text/JavaScript"> 
            alert("Secsessful Collaborate!");
            </script>'
        ;
    }
}
//var_dump();
// phpinfo();
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
        <div id="myDIV" class="header">
        <h2>My To Do List</h2>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <input name="workToDo" type="text" id="myInput" placeholder="what do you want to do? . . .">
            <input type="submit" onclick="window.location.href=window.location.href" class="addBtn" value="add">
        </form>
        </div>

        <ul id="myUL">
        <?php
        foreach($rows as $row) {
        ?>  

            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" id="theForm" method="POST">
                <li>
                    <input type="hidden" name="task_id" value="<?php echo $row->_id; ?>" />
                    <input class="checkbox" type="checkbox" id="task_<?php echo $row->_id; ?>" name="done" onclick="toRemoveTick('<?php echo $row->_id; ?>')" <?php
                    if($row->done == true) {
                        echo 'checked';
                    }
                    ?> />

                    <input type="text" value="<?php echo $row->text;?>"/>
                    
                    <input class="btnCheckbox" type="submit" value="to Do it"/>
                    <input class="btnCheckbox" name="delete" type="submit" value="Delete"/>

                    <input type="hidden" name="theField" id="theField"/>
                    <input class="btnCheckbox" name="collaborate" type="submit" value="collaborate" onclick="window.open('smallPageCollab.php', 
                            'mylala', 
                            'width=300,height=250,left=520, top=250'); 
                    return false;" />
                </li>
            </form>
        <?php } ?>
        </ul>
        
    </body>
</html>
<script type="text/javascript">
    function toRemoveTick(id) {
        var status = 'todo';
        if($("#task_"+id).prop('checked') == true){
            status = 'done';
        }
        $.ajax({
           type: "POST",
           url: window.location.href,
           data: {
                status: status,
                task_id: id
           }, // serializes the form's elements.
           success: function(data)
           {
                alert(status); // show response from the php script.
                location.reload();
           }
         });
    }
</script>
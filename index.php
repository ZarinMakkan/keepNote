<?php require "indexphpPart.php"; ?>
<!DOCTYPE html>
<html>

<head>
    <title>Keep Note For You!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./index.css?v=<?php echo time(); ?>" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <?php include "collaborateModal.php";
    include "indexHeader.php"; ?>

    <ul id="myUL">
        <?php foreach ($rows as $row) { ?>

            <form action="index.php" method="POST">
                <li>
                    <input type="hidden" name="task_id" value="<?php echo $row->_id; ?>" />
                    <input class="checkbox" type="checkbox" id="task_<?php echo $row->_id; ?>" onclick="toChangeTick('<?php echo $row->_id; ?>')" <?php if ($row->done == true) {
                                                                                                                                                        echo 'checked';
                                                                                                                                                    } ?> />
                    <input id="conInput" type="text" value="<?php echo $row->text; ?>" />
                    <input class="btnDelete" name="delete" type="submit" value="Delete" />
                    <input class="btnOpenCollabModal" id="<?php echo $row->_id; ?>" type="button" value="Collaborate">
                </li>
            </form>
        <?php } ?>
    </ul>
    <script type="text/javascript" src="index.js"></script>
</body>

</html>
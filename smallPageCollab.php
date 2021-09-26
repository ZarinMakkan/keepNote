<!DOCTYPE html>
<html>
    <head>
        <title>collabrate</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="./log.css?v=<?php echo time(); ?>" />
    </head>
    <body>
        <form  action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <label>اسم دوستت که میخای این کارو باهاش به اشتراک بزاری رو بزن</label>
            <input name="collabName" type="text"/>
            <input class="btnCheckbox" type="submit" value="To Collab" onclick="window.close()"/>
        </form>
    </body>
</html>
<script>
    window.onunload = refreshParent;
    function refreshParent() {
        window.opener.location.reload();
    }
</script>
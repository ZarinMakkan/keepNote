<!DOCTYPE html>
<html>
    <head>
        <title>collabrate</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="./login.css?v=<?php echo time(); ?>" />
    </head>
    <body  id="smallLabel">
        <label>اسم دوستت که میخای این کارو باهاش به اشتراک بزاری رو بزن</label>
        <input id="thePopupField" type="text"/>
        <input class="btnCheckbox" type="submit" value="To Collab" onclick="doTheSubmit()"/>
    </body>
</html>
<script>
    function doTheSubmit() {
        
        var doc = window.opener.document,
            theForm = doc.getElementById("theForm"),
            theField = doc.getElementById("fieldCollab");
        theField.value = document.getElementById("thePopupField").value;
        
        window.close();
        theForm.submit();
    }
</script>
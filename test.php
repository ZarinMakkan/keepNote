<?php
if(empty($_POST["six"]))
    echo "empty"; 
else {
    echo "full";
    echo "<br>";
    echo $_POST["six"];
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>lafla</title>
    </head>
    <body>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <input type="text"     name="one"   value="foo"                        />
            <input type="text"     name="two"   value="bar"    disabled="disabled" />
            <input type="text"     name="three" value="first"                      />
            <input type="text"     name="three" value="second"                     />

            <input type="checkbox" name="four"  value="baz"                        />
            <input type="checkbox" name="five"  value="baz"    checked="checked"   />
            <input type="checkbox" name="six"   value="qux"    checked="checked" disabled="disabled" />
            <input type="checkbox" name=""      value="seven"  checked="checked"   />

            <input type="radio"    name="eight" value="corge"                      />
            <input type="radio"    name="eight" value="grault" checked="checked"   />
            <input type="radio"    name="eight" value="garply"                     />
            <input type="submit" value="bfshar"/>
        </form>
    </body>
</html>
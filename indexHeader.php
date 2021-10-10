<div id="myDIV" class="header">
    <span><input type="submit" onclick="logout()" id="logOut" value="log out"></span>
    <h2><?php echo $_SESSION['userName']; ?> To Do List</h2>
    <form action="index.php" method="POST">
        <input name="mainText" type="text" id="myInput" placeholder="what do you want to do? . . .">
        <input type="submit" onclick="window.location.href=window.location.href" class="addBtn" value="add">
    </form>
</div>
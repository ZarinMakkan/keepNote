<header id="header" class="container">
    <div id="leftH">
        <div class="faicon" id="accountoption" onclick="modalAccountOption();">
            <span title="account setting" class="far fa-user fa-lg" style="font-size: 25px; line-height: 40px;" </span>
        </div>
        <div class="faicon" id="theme">
            <span id="moon" title="changing theme" class="far fa-moon fa-lg" style="font-size: 22px; line-height: 42px;"></span>
            <span id="sun" title="changing theme">&#xf185</span>
        </div>
    </div>
    <div id="searchbox">
        <span class="osicon fas fa-times fa-lg" id="searchclose"></span>
        <input name="search" type="text" id="search" placeholder="Search ...">
        <span class="osicon fas fa-search fa-lg" id="searchok"></span>
    </div>
    <div id="rightH">
        <div id="logo">
            <img id="logoimg" src="logo/logoLight.png" alt="logo picture" title="logo picture">
        </div>
        <div class="faicon" id="addbord">
            <span title="add a board" class="fas fa-plus fa-lg" style="font-size: 20px; line-height: 43px;"></span>
        </div>
    </div>


    <!-- <form action="index.php" method="POST">
        <input name="mainText" type="text" id="myInput" placeholder="what do you want to do? . . .">
        <input type="submit" onclick="window.location.href=window.location.href" class="addBtn" value="add">
    </form> -->
</header>
<hr class="hr">

<!-- The Modal of account options -->
<div id="accountModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content" id="madalAcouContent">
        <p style="pointer-events: none;">welcome <strong><?php echo $_SESSION['userName']; ?></strong></p>
        <hr class="hr">
        <p><span>&#xf044 </span>Edit Account Info</p>
        <p><span>&#xf1f8 </span>Delete Account</p>
        <p id="logOut" onclick="logout()"><span>&#xf08b </span>Logout</p>
    </div>

</div>
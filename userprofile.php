<?php
    require("usesession.php");
    $username = $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"];
    require("header.php");
    $database = 'if20_karljanar_ki_1';
    $notice = "";
    if(isset($_POST["profilesubmit"])){
        
    }

?>  
    .profile {
        float:left;
        color: whitesmoke;
        text-align: justify;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 18px;
    }
    </style>
    </head>
    <body>
    <img src="img/vp_banner.png" alt="Veebiproge kursuse logo." class="center">
    <hr>
    <div class="topnav">
        <a href="home.php">Kodu</a>
        <a href="writethoughts.php">Kirjuta mõtteid</a>
        <a href="thoughts.php">Loe mõtteid</a>
        <a href='listfilms.php'>Filmide nimekiri</a>
        <a href="addfilms.php">Lisa filme</a>
        <a class="active" href="userprofile.php">Profiil</a>
        <a href="https://github.com/karljanar/vp">GitHub</a>
        <p><a href="?logout=1">Logi välja</a></p>
    </div>
    <hr>
    <form class="profile" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="descriptioninput">Enda tutvustus. </label>
        <br>
        <textarea name="descriptioninput" id="descriptioninput" rows="10" cols="80" placehodler="Minu tutvustus ..."></textarea>
        <label for="bgcolorinput">Minu taustavarv: </label>
        <input type="color" name="bgcolorinput" id="bgcolorinput" value="<?php echo $_SESSION["userbgcolor"]; ?>">
        <label for="txtcolorinput">Minu tekstivarv: </label>
        <input type="color" name="txtcolorinput" id="txtcolorinput" value="<?php echo $_SESSION["usertxtcolor"]; ?>">
        <input type="submit" name="profilesubmit" value="Salvesta profiil">
        <span><?php echo $notice;?></span>
    </form>
</body>
</html>
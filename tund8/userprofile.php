<?php
    require("usesession.php");
    $username = $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"];
    require("header.php");
    require("fnc_common.php");
    require("fnc_user.php");
    $database = 'if20_karljanar_ki_1';
    $notice = "";
    $userdescription = readuserdescription(); //edaspidi pyyab andmebaasist lugeda, kui oleams, kasutab seda 
    if(isset($_POST["profilesubmit"])){
        $description = test_input($_POST["descriptioninput"]);
        $result = storeuserprofile($description, $_POST["bgcolorinput"], $_POST["txtcolorinput"]);
        //peaks tulema ok v error
        if($result == "ok"){
            $notice = "Kasutaja profiil on salvestatud.";
            $_SESSION["userbgcolor"] = $_POST["bgcolorinput"];
            $_SESSION["usertxtcolor"] = $_POST["txtcolorinput"];
            header("Refresh:0");
        }else{
            $notice = "Profilli salvestamine ebaõnnestus.".$result;
        }
    }

?>  
    .profile {
        float:left;
        <?php
        if(isset($_SESSION["usertxtcolor"])){
                echo "\t \t color:" .$_SESSION["usertxtcolor"] .";\n";
            }else{
                echo "\t \t color: #f5f5f5; \n";
            }
            ?>
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
        <a href="listfilmpersons.php">Näitlejad</a>
        <a href="addfilms.php">Lisa filme</a>
        <a href="filmrelations.php">Filmi seosed</a>
        <a class="active" href="userprofile.php">Profiil</a>
        <a href="https://github.com/karljanar/vp">GitHub</a>
        <p><a href="?logout=1">Logi välja</a></p>
    </div>
    <hr>
    <form class="profile" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="descriptioninput">Enda tutvustus. </label>
        <br>
        <textarea name="descriptioninput" id="descriptioninput" rows="10" cols="80" placehodler="Minu tutvustus ..."><?php echo $userdescription; ?></textarea>
        <br>
        <label for="bgcolorinput">Minu taustavarv: </label>
        <input type="color" name="bgcolorinput" id="bgcolorinput" value="<?php echo $_SESSION["userbgcolor"]; ?>">
        <br>
        <label for="txtcolorinput">Minu tekstivarv: </label>
        <input type="color" name="txtcolorinput" id="txtcolorinput" value="<?php echo $_SESSION["usertxtcolor"]; ?>">
        <br>
        <input type="submit" name="profilesubmit" value="Salvesta profiil">
        <span><?php echo $notice;?></span>
    </form>
</body>
</html>
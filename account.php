<?php
    require("header.php");
    $firstnameerror = "";
    $lastnameerror = "";
    $emailerror = "";
    $passworderror = "";
    $gendererror = "";
    $firstname = "";
    $lastname = "";
    $email = "";
    $gender = "";
    $passwordmatcherror = "";

    if(isset($_POST["registersubmit"])){
        $firstname = $_POST["firstnameinput"];
        $lastname = $_POST["lastnameinput"];
        $email = $_POST["emailinput"];
        $gender = $_POST["genderinput"];

        if(empty($_POST["firstnameinput"])){
            $firstnameerror = "Sisestage eesnimi.";
        }
        if(empty($_POST["lastnameinput"])){
            $lastnameerror = "Sisestage perekonnanimi.";
        }
        if(empty($_POST["emailinput"])){
            $emailerror = "Sisestage e-post.";
        }
        if(strlen($_POST["passwordinput"]) < 8){
            $passworderror = "Liiga lühike parool.";
        }
        if(($_POST["passwordinput"]) != ($_POST["passwordsecondaryinput"])){
            $passwordmatcherror = "Paroolid ei kattu.";
        }
        if(empty($_POST["genderinput"])){
            $gendererror = "Sisestage sugu.";
        }
        if(empty($firstnameerror) and empty($lastnameerror) and empty($emailerror) and empty($passworderror) and empty($passwordmatcherror) and empty($gendererror)){
            $storeinfo = "";
        }
    }
?>

    .register {
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
        <a class="active" href="account.php">Kasutaja</a>
        <a href="https://github.com/karljanar/vp">GitHub</a>
    </div>
    <hr>
    <form class="register" method="POST">
        <label>Eesnimi: </label>
        <input type="text" name="firstnameinput" id="firstnameinput" value="<?php echo $firstname; ?>">
        <span style="color:firebrick"><?php echo $firstnameerror; ?></span><br>
        <label>Perekonnanimi: </label>
        <input type="text" name="lastnameinput" id="lastnameinput" value="<?php echo $lastname; ?>">
        <span style="color:firebrick"><?php echo $lastnameerror; ?></span><br>
        <label>E-post: </label>
        <input type="email" name="emailinput" id="emailinput" value="<?php echo $email; ?>">
        <span style="color:firebrick"><?php echo $emailerror; ?></span><br>
        <label>Parool: </label>
        <input type="password" name="passwordinput" id="passwordinput" placeholder="parool">
        <span style="color:firebrick"><?php echo $passworderror; ?></span><br>
        <label>Korrake parooli: </label>
        <input type="password" name="passwordsecondaryinput" id="passwordsecondaryinput" placeholder="parool">
        <span style="color:firebrick"><?php echo $passwordmatcherror; ?></span><br>
        <label>Sugu: </label>
        <input type="radio" name="genderinput" id="gendermale" value="1" <?php if($gender == "1"){echo " checked";}?>>
        <label for="gendermale">Mees</label>
        <input type="radio" name="genderinput" id="genderfemale" value="2" <?php if($gender == "2"){echo " checked";}?>>
        <label for="genderfemale">Naine</label>
        <span style="color:firebrick"><?php echo $gendererror; ?></span><br>
        <input type="submit" name="registersubmit" id="registersubmit" value="Registreeri">
    </form>
</body>
</html>

<?php
    require("usesession.php");
    $username = $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"];
    require("header.php");
    require("fnc_film.php");
    //kas vajutati salvestus nuppu
    $inputerror = "";
    $filmhtml = "";
    if(isset($_POST["filmsubmit"])){
        if((empty($_POST["titleinput"])) or empty($_POST["genreinput"]) or empty($_POST["studioinput"]) or empty($_POST["directorinput"])){
            $inputerror .= "Osa infot on sisestamata! ";
        }
        if($_POST["yearinput"] < 1895 or $_POST["yearinput"] > date('Y')){
            $inputerror .= "Aasta ei klapi.";
        }
        if(empty($inputerror)){
            $storeinfo = storefilminfo($_POST["titleinput"], $_POST["yearinput"], $_POST["durationinput"], $_POST["genreinput"], $_POST["studioinput"], $_POST["directorinput"]);
            if($storeinfo == 1){
                $filmhtml = readfilms(0);
            }
            else{
                $filmhtml = "<p>Kahjuks filmi info savelstamine ebaõnnestus.</p>";
            }
        }
    }
?>
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
        <a class="active" href='addfilms.php'>Lisa filme</a>
        <a href="filmrelations.php">Filmi seosed</a>
        <a href="userprofile.php">Profiil</a>
        <a href="https://github.com/karljanar/vp">GitHub</a>
        <p><a href="?logout=1">Logi välja</a></p>
    </div>
    <!--<ul>
        <li><a href="home.php">Home</a> loetelu
        </li></ul>-->
    <hr>
    <form method="POST">
        <label for="titleinput">Filmi pealkiri</label>
        <input type="text" name="titleinput" id="titleinput" placeholder="Filmide pealkiri">
        <br>
        <label for="yearinput">Filmi valmimisaasta</label>
        <input type="number" name="yearinput" id="yearinput" value="<?php echo date("Y"); ?>">
        <br>
        <label for="durationinput">Filmi kestus</label>
        <input type="number" name="durationinput" id="durationinput" value="90">
        <br>
        <label for="genreinput">Filmi žanr</label>
        <input type="text" name="genreinput" id="genreinput" placeholder="Filmi Žanr">
        <br>
        <label for="studioinput">Filmi tootja</label>
        <input type="text" name="studioinput" id="studioinput" placeholder="Filmi tootja/stuudio">
        <br>
        <label for="directorinput">Filmi lavastaja</label>
        <input type="text" name="directorinput" id="directorinput" placeholder="Filmi lavastaja">
        <br>
        <input type="submit" name="filmsubmit" value="Salvesta filmi info">
    </form>
    <p><?php echo $inputerror; ?></p>
    <hr>
    <p><?php echo $filmhtml; ?></p>
    </body>
</html>


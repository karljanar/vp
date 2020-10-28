<?php
    require("usesession.php");
    require("header.php");
    //kas vajutati salvestus nuppu
    $inputerror = "";

    if(isset($_POST["photosubmit"])){
       //var_dump($_POST);
       //var_dump($_FILES);
       //kas on pilt
       $check = getimagesize($_FILES["photoinput"]["tmp_name"]);
       if($check !== false){
           
       }


       move_uploaded_file($_FILES["photoinput"]["tmp_name"], "photoupload_orig/" .$_FILES["photoinput"]["name"]);
    }
?>
        .pilt {
            float: none;
            <?php
            if(isset($_SESSION["usertxtcolor"])){
                    echo "color:" .$_SESSION["usertxtcolor"] .";\n";
                }else{
                    echo "color: #f5f5f5; \n";
                }
                ?>
            text-align: left;
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
        <a href='addfilms.php'>Lisa filme</a>
        <a href="filmrelations.php">Filmi seosed</a>
        <a href="userprofile.php">Profiil</a>
        <a class="active" href=photoupload.php>Galerii Üles</a>
        <a href="https://github.com/karljanar/vp">GitHub</a>
        <p><a href="?logout=1">Logi välja</a></p>
    </div>
    <!--<ul>
        <li><a href="home.php">Home</a> loetelu
        </li></ul>-->
    <hr>
    <form method="POST" class="pilt" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
        <label for="photoinput">Vali pildifail</label>
        <input id="photoinput" name="photoinput" type="file">
        <br>
        <label for="altinput">Lisa pildi lühikirjeldus / Alternatiiv tekst</label>
        <input id="altinput" name="altinput" type="text" placeholder="Pildi lühikirjeldus ...">
        <br>
        <label>Määra privaatsustase</label>
        <br>  
        <input id="privinput1" name="privinput" type="radio" value="1">
        <label for="privinput1">Privaatne (ainult ise)</label>
        <br>  
        <input id="privinput2" name="privinput" type="radio" value="2">
        <label for="privinput2">Sisseloginud kasutajatele</label>
        <br>  
        <input id="privinput3" name="privinput" type="radio" value="3">
        <label for="privinput3">Avalik</label>
        <br>
        <input type="submit" name="photosubmit" value="Lae pilt üles">
    </form>
    <p><?php echo $inputerror; ?></p>
    </body>
</html>


<?php
    require("usesession.php");
    require("header.php");
    require("fnc_film.php");
    require("fnc_filmrelations.php");
    $sortby = 0;
    $sortorder = 0;
?>


        table {
            float: none;
            <?php
            if(isset($_SESSION["usertxtcolor"])){
                    echo "\t \t color:" .$_SESSION["usertxtcolor"] .";\n";
                }else{
                    echo "\t \t color: #f5f5f5; \n";
                }
                ?>
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 20px;
            border-collapse: collapse;
            border: 2px solid black;
            <?php
            if(isset($_SESSION["usertxtcolor"])){
                echo "\t \t border:" ." " ."2px" .$_SESSION["usertxtcolor"] .";\n";
            }else{
                echo "\t \t border: 2px #f5f5f5; \n";
                }
            ?>
        }

        table, td, th {
            border: 1px solid black;
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
        <a class="active" href="listfilmpersons.php">Näitlejad</a>
        <a href="addfilms.php">Lisa filme</a>
        <a href="filmrelations.php">Filmi seosed</a>
        <a href="userprofile.php">Profiil</a>
        <a href="https://github.com/karljanar/vp">GitHub</a>
        <p><a href="?logout=1">Logi välja</a></p>
    </div>

    <hr>
    <?php
        if(isset($_GET["sortby"]) and isset($_GET["sortorder"])){
            if($_GET["sortby"] >= 1 and $_GET["sortby"] <= 4){
                $sortby = intval($_GET["sortby"]);
            }
            if($_GET["sortorder"] == 1 or $_GET["sortorder"] == 2){
                $sortorder = intval($_GET["sortorder"]);
            }
        }
        echo readpersoninmovie($sortby, $sortorder);
    ?>
    </body>
</html>

 

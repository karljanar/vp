<?php
require("../../config.php");
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link rel='icon' href='img/vp_logo_small.png' type='image/x-icon'>
    <link rel="stylesheet" type="text/css" href="style/navigation.css">
    <title>Veebiproge</title>
    <?php
        if(isset($tolink)){
            echo $tolink;
	    }
    ?>
    <style>
        body{
            <?php 
                if(isset($_SESSION["userbgcolor"])){
                    echo "\t \t background-color:" .$_SESSION["userbgcolor"] .";\n";
                }else{
                    echo "\t \t background-color: #2e3440; \n";
                }
                if(isset($_SESSION["usertxtcolor"])){
                    echo "\t \t color:" .$_SESSION["usertxtcolor"] .";\n";
                }else{
                    echo "\t \t color: #f5f5f5; \n";
                }
            ?>
            background-repeat: no-repeat;
            background-size: auto;
            font-family: Arial, Helvetica, sans-serif;
        }

        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 80%;
        }
        
        .main {
        float: center;
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
        font-size: 18px;
        }

        .table {
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
        <a   href="home.php">Kodu</a>
        <a href="writethoughts.php">Kirjuta mõtteid</a>
        <a href="thoughts.php">Loe mõtteid</a>
        <a href='listfilms.php'>Filmide nimekiri</a>
        <a href="listfilmpersons.php">Näitlejad</a>
        <a href="addfilms.php">Lisa filme</a>
        <a href="filmrelations.php">Filmi seosed</a>
        <a href="movieinfo.php">Filmi info</a>
        <a href="addandmed.php">Lisa infot</a>
        <a href="userprofile.php">Profiil</a>
        <a href="photoupload.php">Galerii Üles</a>
        <a href="publicphotogallery.php">Avalik galerii</a>
        <a href="privatephotogallery.php">Privaatne galerii</a>
        <a href="https://github.com/karljanar/vp">GitHub</a>
        <p><a href="?logout=1">Logi välja</a></p>
    </div>



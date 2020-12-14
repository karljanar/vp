<?php
require("../../config.php");
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style/navigation.css">
    <title>Veebiproge</title>
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

        .mainl {

        <?php
        if(isset($_SESSION["usertxtcolor"])){
                echo "\t \t color:" .$_SESSION["usertxtcolor"] .";\n";
            }else{
                echo "\t \t color: #f5f5f5; \n";
            }
            ?>

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
    <hr>
    <div class="topnav">
        <a href="viljavedu.php">Viljaveo sisestus</a>
        <a href="vilikokk.php">Viljaveo kokkuvõte</a>
    </div>



<?php
require("../../config.php");
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link rel='icon' href='img/vp_logo_small.png' type='image/x-icon' >
    <title>Veebiproge</title>
    <style>
        <?php 
            echo "body {\n";
            if(isset($_SESSION["userbgcolor"])){
                echo "\t \t background-color:" .$_SESSION["userbgcolor"] .";\n";
            }else{
                echo "\t \t background-color: #2e3440; \n";
            }
            echo "\t \t background-repeat: no-repeat; \n";
            echo "\t \t background-size: auto; \n";
            if(isset($_SESSION["usertxtcolor"])){
                echo "\t \t color:" .$_SESSION["usertxtcolor"] .";\n";
            }else{
                echo "\t \t color: #f5f5f5; \n";
            }
            echo "\t \t font-family: Arial, Helvetica, sans-serif; \n";
            echo "\t \t }\n";
            ?>
        /*body {
            background-color: #2e3440;
            background-repeat: no-repeat;
            background-size: auto;
            color: whitesmoke;
            font-family: Arial, Helvetica, sans-serif;
        }*/
        .topnav {
            <?php 
            if(isset($_SESSION["userbgcolor"])){
                echo "background-color:" .$_SESSION["userbgcolor"] .";\n";
            }else{
                echo "background-color: #2e3440; \n";
            };?>
            overflow: hidden;
            text-align: center;
        }
        .topnav a {
            float: none;
            <?php
            if(isset($_SESSION["usertxtcolor"])){
                echo "color:" .$_SESSION["usertxtcolor"] .";\n";
            }else{
                echo "color: #f5f5f5; \n";
            }
            ?>
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }
        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }
        .topnav a.active {
            background-color: #56A3A6;
            color: white;
        }
        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 80%;
        }
      



<?php
    require("header.php");
    //require("usesession.php");
    require("fnc_vili.php");
    $sortby = 0;
    $sortorder = 0;
    
    ?>
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
        echo readcars($sortby, $sortorder);
    ?>

<?php
    require("usesession.php");
    require("header.php");
    require("fnc_film.php");
    require("fnc_filmrelations.php");
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
        echo readpersoninmovie($sortby, $sortorder);
    ?>
    </body>
</html>

 

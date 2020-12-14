<?php
    require("header.php");
    require("usesession.php");
    require("fnc_news.php");
    $fileuploaddir_news = "newsphoto/";
    $news = getUserNews();
    $news = htmlspecialchars_decode($news);
    
    /* if(isset($_POST["newsedit"])){
        print_r($_POST);
        $ID = $_GET['id'];
        echo $ID;
        //header("Location: newseditor.php?news=");
    } */
    ?>

<hr>
    <?php 
        echo $news;
    ?>
<br>

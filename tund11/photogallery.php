<?php
    require("usesession.php");
    require("header.php");
    require("fnc_photo.php");

    $notice = "";
    $fileuploaddir_orig = "photoupload_orig/";
    $fileuploaddir_normal = "photoupload_normal/";
    $fileuploaddir_thumb = "photoupload_thumb/";

    $publicphotothumbshtml = readAllPublicPhotoThumbs(2);


  //kas vajutati salvestusnuppu
  
?>
    <hr>
    <h2>Fotogalerii</h2>
    <?php 
        echo $publicphotothumbshtml;
    ?>
    </body>
</html>

 

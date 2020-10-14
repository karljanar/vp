 <?php
     session_start();
     //kas on sisse loginud, kui pole ss saadab sisse logima
     if(isset($_GET["logout"])){
         session_destroy();
         header("Location: page.php");
         exit();
     }
     if(!isset($_SESSION["userid"])){
         header("location: page.php");
         exit();
     }
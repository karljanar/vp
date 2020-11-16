<?php
  require("SessionManager.class.php");
  //session_start();

    //sessiooni haldus "greeny.cs.tlu.ee"
  SessionManager::sessionStart("vp", 0, "/~karlkin/");
  
    //logime välja
  if(isset($_GET["logout"])){
	  session_destroy();
	  header("Location: page.php");
	  exit();
  }
  
  //kas on sisseloginud, kui pole, saadame sisselogimise lehele
  if(!isset($_SESSION["userid"])){
	  header("Location: page.php");
	  exit();
  }
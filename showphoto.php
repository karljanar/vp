<?php
    //header("Content-type: image/jpeg");
    require("usesession.php");
    require("fnc_photo.php");
    require("../../config.php");
    $photoid = $_REQUEST["photo"];
    $photodir = "photoupload_normal/";
    $filename = getImageInfo($photoid);
    echo $filename;
    $ext = explode(".",$filename);
    if($ext[1] == 'jpg' or $ext[1] == 'jpeg'){
        $cType = "image/jpeg";
    } elseif($ext[1] == 'png') {
        $cType = "image/png";
    } elseif($ext[1] == 'gif') {
        $cType = "image/gif";
    }

    //echo $photodir .$filename;
    //header("Content-type: " .$cType);
    //readfile($photodir .$_REQUEST["photo"]);
    header("Content-type: " .$cType);
	readfile($photodir. $filename);

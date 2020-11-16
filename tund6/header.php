<?php
require("../../config.php");
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link rel='icon' href='img/vp_logo_small.png' type='image/x-icon' >
    <title><?php echo $username; ?> ehitab lehte</title>
    <style>
        body {

            background-color: #2e3440;
            background-repeat: no-repeat;
            background-size: auto;
            color: whitesmoke;
            font-family: Arial, Helvetica, sans-serif;
        }
        .topnav {
            background-color: #2e3440;
            overflow: hidden;
            text-align: center;
        }
        .topnav a {
            float: none;
            color: whitesmoke;
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
      



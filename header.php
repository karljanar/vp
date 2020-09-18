<?php
$username = "Janar";
require("../../config.php");
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $username; ?> ehitab lehte</title>
    <style>
        body {

            background-color: #2e3440;
            background-repeat: no-repeat;
            background-size: auto;
            color: whitesmoke;
            font-family: Arial, Helvetica, sans-serif;
        }
        /* Add a black background color to the top navigation */
        .topnav {
            background-color: #2e3440;
            overflow: hidden;
        }
        /* Style the links inside the navigation bar */
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
            background-color: firebrick;
            color: white;
        }


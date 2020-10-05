<?php
require("header.php");
require("fnc_film.php");
$filmhtml = readfilms();
?>
        </style>
    </head>
    <body>
    <img src="img/vp_banner.png" alt="Veebiproge kursuse logo." class="center">
    <hr>
    <div class="topnav">
        <a href="home.php">Kodu</a>
        <a href="writethoughts.php">Kirjuta mõtteid</a>
        <a href="thoughts.php">Loe mõtteid</a>
        <a class="active" href='listfilms.php'>Filmide nimekiri</a>
        <a href="addfilms.php">Lisa filme</a>
        <a href="https://github.com/karljanar/vp">GitHub</a>
    </div>
    <!--<ul>
        <li><a href="home.php">Home</a> loetelu
        </li></ul>-->
    <hr>
    <?php echo readfilms(0);?> 
    </body>
</html>


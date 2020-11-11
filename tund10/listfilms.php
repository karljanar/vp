<?php
    require("usesession.php");
    $username = $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"];
    require("header.php");
    require("fnc_film.php");
    $filmhtml = readfilms();
?>
        </style>
    </head>
<body>
    <hr>
    <?php echo readfilms(0);?> 
</body>
</html>


<?php
    require("usesession.php");
    $username = $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"];
    require("header.php");
    $database = 'if20_karljanar_ki_1';
    $ideahtml = "";
    $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
    $stmt = $conn->prepare("SELECT idea FROM myideas");
    //seon tulemuse muutaujaga
    $stmt->bind_result($ideafromdb);
    $stmt->execute();
    while($stmt->fetch()){
        $ideahtml .= "<p>".$ideafromdb."</p>";
    }
    $stmt->close();
    $conn->close();

?>
        </style>
    </head>
    <body>
    <img src="img/vp_banner.png" alt="Veebiproge kursuse logo." class="center">
    <hr>
    <div class="topnav">
        <a href="home.php">Kodu</a>
        <a href="writethoughts.php">Kirjuta mõtteid</a>
        <a class="active" href="thoughts.php">Loe mõtteid</a>
        <a href='listfilms.php'>Filmide nimekiri</a>
        <a href="addfilms.php">Lisa filme</a>
        <a href="filmrelations.php">Filmi seosed</a>
        <a href="userprofile.php">Profiil</a>
        <a href="https://github.com/karljanar/vp">GitHub</a>
        <p><a href="?logout=1">Logi välja</a></p>
    </div>
    <hr>
    <?php echo $ideahtml; ?>
</body>
</html>

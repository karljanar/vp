<?php
require("header.php");
$database = 'if20_karljanar_ki_1';
if(isset($_POST["ideasubmit"]) and !empty($_POST["ideainput"])){
    //loome uhenduse
    $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
    //valmistan ette sql kasu andmete kirjutamiseks
    $stmt = $conn->prepare("INSERT INTO myideas (idea) VALUES (?)");
    echo $conn->error;
    // i -int, d- dec, s-str
    $stmt->bind_param("s", $_POST["ideainput"]);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

?>
    </style>
    </head>
    <body>
    <img src="img/vp_banner.png" alt="Veebiproge kursuse logo." class="center">
    <hr>
    <div class="topnav">
        <a href="home.php">Kodu</a>
        <a class="active" href="writethoughts.php">Kirjuta mõtteid</a>
        <a href="thoughts.php">Loe mõtteid</a>
        <a href="https://github.com/karljanar/vp">GitHub</a>
    </div>
    <hr>
    <form method="POST">
        <label>Kirjutage oma esimene lambi mõte. </label>
        <input type="text" name="ideainput" placeholder="mõttekoht">
        <input type="submit" name="ideasubmit" value="Saada teele">
    </form>
</body>
</html>
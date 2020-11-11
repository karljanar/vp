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
    <hr>
    <?php echo $ideahtml; ?>
</body>
</html>

<?php
    require("usesession.php");
    require("../../config.php");
    $database = "if20_karljanar_ki_1";

    $id = $_REQUEST["photoid"];
	$rating = $_REQUEST["rating"];

    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("INSERT INTO vpphotoratings (photoid, userid, rating) VALUES(?,?,?)");
	$stmt->bind_param("iii", $id, $_SESSION["userid"], $rating);
	$stmt->execute();
	$stmt->close();

	$stmt = $conn->prepare("SELECT AVG(rating) as AvgValue FROM vpphotoratings WHERE photoid = ?");
	$stmt->bind_param("i", $id);
	$stmt->bind_result($score);
	$stmt->execute();
	$stmt->fetch();

	$stmt->close();
	$conn->close();
    echo round($score, 2); 
    
    //

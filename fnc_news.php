<?php
	$database = "if20_karljanar_ki_1";

	function storeNews($newstitle, $news, $expire){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("INSERT INTO vpnews (userid, title, content, expire) VALUES (?, ?, ?, ?)");
		echo $conn->error;
		$stmt->bind_param("isss", $_SESSION["userid"], $newstitle, $news, $expire);
		if($stmt->execute()){
			$notice = 1;
		} else {
			//echo $stmt->error;
            //$notice = 0;
            $notice = $conn->error;
		}
		$stmt->close();
		$conn->close();
		return $notice;
    }  
    
    function getNews($count){
        $news = null;
        $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT firstname, lastname, title, content FROM vpnews JOIN vpusers ON vpnews.userid = vpusers.vpusers_id WHERE deleted IS NULL GROUP BY vpnews_id DESC LIMIT ?" );
        echo $conn->error;
        $stmt->bind_param('i', $count);
		$stmt->bind_result($firstnamefromdb, $lastnamefromdb, $newstitlefromdb, $newscontentfromdb);
        $stmt->execute();
        while($stmt->fetch()){
            $news .= '<h2>' .$newstitlefromdb .'</h2>';
            $news .= $newscontentfromdb ."\n";
            $news .= '<p>Autor: ' .$firstnamefromdb ." " .$lastnamefromdb ."\n";
        }

        $stmt->close();
		$conn->close();
		return $news;
    }

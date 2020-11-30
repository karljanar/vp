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
        $stmt = $conn->prepare("SELECT firstname, lastname, title, content, filename, alttext FROM vpnews JOIN vpusers ON vpnews.userid = vpusers.vpusers_id JOIN vpnewsphotos ON vpusers.vpusers_id = vpnewsphotos.userid WHERE deleted IS NULL GROUP BY vpnews_id DESC LIMIT ?" );
        echo $conn->error;
        $stmt->bind_param('i', $count);
		$stmt->bind_result($firstnamefromdb, $lastnamefromdb, $newstitlefromdb, $newscontentfromdb, $filenamefromdb, $alttextfromdb);
        $stmt->execute();
        while($stmt->fetch()){
            $news .= '<h2>' .$newstitlefromdb .'</h2>';
			$news .= $newscontentfromdb ."\n";
			$news .= '<img src="' .$GLOBALS["fileuploaddir_news"] .$filenamefromdb .'" alt="' .$alttextfromdb .'">' ."\n";
            $news .= '<p>Autor: ' .$firstnamefromdb ." " .$lastnamefromdb ."\n";
        }

        $stmt->close();
		$conn->close();
		return $news;
	}
	
	function storeNewsPhotoData($filename, $alttext){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("INSERT INTO vpnewsphotos (userid, filename, alttext) VALUES (?, ?, ?)");
		echo $conn->error;
		$stmt->bind_param("iss", $_SESSION["userid"], $filename, $alttext);
		if($stmt->execute()){
			$notice = 1;
		} else {
			//echo $stmt->error;
			$notice = 0;
		}
		$stmt->close();
		$conn->close();
		return $notice;
	} 

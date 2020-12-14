<?php
	$database = "if20_karljanar_ki_1";

	function storeNews($newstitle, $news, $expire, $filename, $alttext){
		/* $notice = null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("INSERT INTO vpnews (userid, title, content, expire, vpnewsphotoid) VALUES (?, ?, ?, ?, ?)");
		echo $conn->error;
		$stmt->bind_param("isss", $_SESSION["userid"], $newstitle, $news, $expire, $vpnewsphotoid);
		if($stmt->execute()){
			$notice = 1;
		} else {
			//echo $stmt->error;
            //$notice = 0;
            $notice = $conn->error;
		}
		$stmt->close();
		$conn->close();
		return $notice; */


		$response = 0;
		$photoid = null;
		//kõigepealt foto!
		//echo "SALVESTATAKSE UUDIST!";
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("INSERT INTO vpnewsphotos (userid, filename, alttext) VALUES(?, ?, ?)");
		echo $conn->error;
		$stmt->bind_param("iss", $_SESSION["userid"], $filename, $alttext);
		if($stmt->execute()){
			$photoid = $conn->insert_id;
		}
		$stmt->close();
		
		//nüüd uudis ise
		$stmt = $conn->prepare("INSERT INTO vpnews (userid, title, content, vpnewsphotoid, expire) VALUES (?, ?, ?, ?, ?)");
		echo $conn->error;
		$stmt->bind_param("issis", $_SESSION["userid"], $newstitle, $news, $photoid, $expire);
		if($stmt->execute()){
			$response = 1;
		} else {
			$response = 0;
		}
		$stmt->close();
		$conn->close();
		return $response;
    }  
    
    function getNews($count){
		$news = null;
		$today = date("Y-m-d");
        $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT firstname, lastname, title, content, filename, alttext FROM vpnews JOIN vpusers ON vpnews.userid = vpusers.vpusers_id JOIN vpnewsphotos ON vpnews.vpnewsphotoid = vpnewsphotos.vpnewsphotos_id WHERE vpnews.expire >= ? AND deleted IS NULL GROUP BY vpnews_id DESC LIMIT ?" );
        echo $conn->error;
        $stmt->bind_param('is', $count, $today);
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
	
	function getUserNews(){
		$news = null;
		$today = date("Y-m-d");
        $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT vpnews_id, firstname, lastname, title, content, filename, alttext FROM vpnews JOIN vpusers ON vpnews.userid = vpusers.vpusers_id JOIN vpnewsphotos ON vpnews.vpnewsphotoid = vpnewsphotos.vpnewsphotos_id WHERE vpnews.expire >= ? AND vpnews.userid = ? AND deleted IS NULL GROUP BY vpnews_id DESC");
		echo $conn->error;
		$stmt->bind_param("si", $today, $_SESSION["userid"]);
		$stmt->bind_result($vpnews_id, $firstnamefromdb, $lastnamefromdb, $newstitlefromdb, $newscontentfromdb, $filenamefromdb, $alttextfromdb);
        $stmt->execute();
        while($stmt->fetch()){
			$news .= '<form method="POST">';
			$news .= "<div> \n";
            $news .= '<h2>' .$newstitlefromdb .'</h2>';
			$news .= $newscontentfromdb ."\n";
			$news .= '<img src="' .$GLOBALS["fileuploaddir_news"] .$filenamefromdb .'" alt="' .$alttextfromdb .'">' ."\n";
			$news .= '<p>Autor: ' .$firstnamefromdb ." " .$lastnamefromdb ."\n";
			$news .= '<input type="submit" formaction="newseditor.php?news='.$vpnews_id.'" value="Muuda uudist!">' ."\n";
			$news .= "</div> \n";
			$news .= '</form>' ."\n";
        }

        $stmt->close();
		$conn->close();
		
		return $news;
	}

	function changeNews($newsid){
		$news = null;
		$today = date("Y-m-d");
        $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT title, content, filename, alttext, vpnews_id FROM vpnews JOIN vpusers ON vpnews.userid = vpusers.vpusers_id JOIN vpnewsphotos ON vpnews.vpnewsphotoid = vpnewsphotos.vpnewsphotos_id WHERE vpnews.vpnews_id = ?" );
        echo $conn->error;
        $stmt->bind_param('i', $newsid);
		$stmt->bind_result($newstitlefromdb, $newscontentfromdb, $filenamefromdb, $alttextfromdb, $vpnews_id);
		$stmt->execute();
		$stmt->fetch();
        /* while($stmt->fetch()){
            $news .= '<h2>' .$newstitlefromdb .'</h2>';
			$news .= $newscontentfromdb ."\n";
			$news .= '<img src="' .$GLOBALS["fileuploaddir_news"] .$filenamefromdb .'" alt="' .$alttextfromdb .'">' ."\n";
            $news .= '<p>Autor: ' .$firstnamefromdb ." " .$lastnamefromdb ."\n";
        } */

        $stmt->close();
		$conn->close();
		$news = array($newstitlefromdb, $newscontentfromdb, $filenamefromdb, $alttextfromdb, $vpnews_id);
		return $news;
	}

	function storeUpdatedNews($newstitle, $news, $expire, $filename, $alttext, $newsid){

		$response = null;
		$photoid = null;
		//kõigepealt foto!
		//echo "SALVESTATAKSE UUDIST!";
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("UPDATE vpnewsphotos SET filename = ?, alttext = ? WHERE vpnewsphotos_id = ?");
		echo $conn->error;
		$stmt->bind_param("ssi", $filename, $alttext, $newsid);
		if($stmt->execute()){
			$response .= "Pilt timmis" .$filename .$alttext .$newsid;
		} else {
			$response .= "Pilt katki".$conn->error;
		}
		$stmt->close();
		//nüüd uudis ise
		$stmt = $conn->prepare("UPDATE vpnews SET title = ?, content = ?, expire = ? WHERE vpnews_id = ?");
		echo $conn->error;
		$stmt->bind_param("sssi", $newstitle, $news, $expire, $newsid);
		if($stmt->execute()){
			$response .= " Uudis timmis";
		} else {
			$response .= $conn->error;
		}
		$stmt->close();
		$conn->close();
		return $response;
    }  

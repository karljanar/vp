<?php
	$database = "if20_karljanar_ki_1";

	function saveCar($regnum, $sissm, $emptym){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("INSERT INTO viljavedu (registrinumber, sisenemismass, tuhimass) VALUES (?, ?, ?)");
		echo $conn->error;
		$stmt->bind_param("sdd", $regnum, $sissm, $emptym);
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
	
	function updateCar($veoid, $emptym){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("UPDATE viljavedu SET tuhimass = ? WHERE veo_id = ?");
		echo $conn->error;
		$stmt->bind_param("di", $emptym, $veoid);
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
	
	function readcartoselect($selected){
        $notice = "<p>Hetkel on koik autod lahkunud</p> \n";
        $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT veo_id, registrinumber, sisenemismass FROM viljavedu WHERE tuhimass IS NULL");
        echo $conn->error;
        $stmt->bind_result($idfromdb, $regnumfromdb, $sissm);
        $stmt->execute();
        $cars = "";
        while($stmt->fetch()){
            $cars .= '<option value="' .$idfromdb .'"';
            if(intval($idfromdb) == $selected){
                $cars .=" selected";
            }
            $cars .= ">" .$regnumfromdb ."   " .$sissm ."</option> \n";
        }
        if(!empty($cars)){
            $notice = '<select name="carinput" id="carinput">' ."\n";
            $notice .= '<option value="" selected disabled>Vali vedu</option>' ."\n";
            $notice .= $cars;
            $notice .= "</select> \n";
        }
        $stmt->close();
        $conn->close();
        return $notice;
    }



	function readcars($sortby, $sortorder){
        $notice = "<p>Kahjuks ei leidnud vedusi.</p>";
        $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $sqlphrase = "SELECT registrinumber, sisenemismass - tuhimass FROM viljavedu";
        if($sortby == 0){
            $stmt = $conn->prepare($sqlphrase);
        }
        if($sortby == 4){
            if($sortorder == 1){
                $stmt = $conn->prepare($sqlphrase ." ORDER BY registrinumber");
            } else {
                $stmt = $conn->prepare($sqlphrase ." ORDER BY registrinumber DESC");
            }
        }
        
        echo $conn->error;
        $stmt->bind_result($regnumfromdb, $mfromdb);
        $stmt->execute();
		$lines = "";
		//$mass = $sissmfromdb - $emptymfromdb;
        while($stmt->fetch()){
            $lines .= "<tr> \n";
            $lines .= "\t <td>" .$regnumfromdb ."</td>";
            $lines .= "\t <td>" .round($mfromdb, 2) ."kg"."</td>";
            $lines .= "</tr> \n";
        }
        if(!empty($lines)){
            $notice = "<table> \n";
            $notice .= "<tr> \n";
            //$notice .= "<th>Isik</th>";
			$notice .= '<th>Registrinumber &nbsp; <a href="?sortby=4&sortorder=1">&uarr;</a> &nbsp; <a href="?sortby=4&sortorder=2">&darr;</a></th>' ."\n";
			$notice .= "<th>Veo kogus</th>";
            $notice .= "</tr> \n";
            $notice .= $lines;
            $notice .= "</table> \n";
        }
        $stmt->close();
        $conn->close();
        return $notice;
    }
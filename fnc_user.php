<?php
    $database = "if20_karljanar_ki_1";

    function signup($firstname, $lastname, $email, $gender, $birthdate, $password){
        $result = null;
        $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("INSERT INTO vpusers (firstname, lastname, birthdate, gender, email, password) VALUES(?,?,?,?,?,?)");
        echo $conn->error;

        //kryptib parooli
        $options = ["cost" => 12, "salt" => substr(sha1(rand()), 0, 22)];
        $pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);

        $stmt->bind_param("sssiss", $firstname, $lastname, $birthdate, $gender, $email, $pwdhash);

        if($stmt->execute()){
            $result = "ok";
        } else {
            $result = $stmt->error;
        }
        $stmt->close();
        $conn->close();
        return $result;
    } //f sngup loppeb

    function signin($email, $password){
        $result = null;
        $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT password FROM vpusers WHERE email = ?");
        echo $conn->error;
        $stmt->bind_param("s", $email);
        $stmt->bind_result($passwordfromdb);
        if($stmt->execute()){
            //kui kask timmis
            if($stmt->fetch()){
                //kui tuli vaste timmis kasutaja
                if(password_verify($password, $passwordfromdb)){
                    //parool korras
                    $stmt->close();
                    //loen sisse loginud kasutaja nime ja id
                    $stmt = $conn->prepare("SELECT vpusers_id, firstname, lastname FROM vpusers WHERE email = ?");
                    echo $conn->error;
                    $stmt->bind_param("s", $email);
                    $stmt->bind_result($idfromdb, $firstnamefromdb, $lastanmefromdb);
                    $stmt->execute();
                    $stmt->fetch();
                    //salvestan saadud info sessiooni muutujatesse
                    $_SESSION["userid"] = $idfromdb;
                    $_SESSION["userfirstname"] = $firstnamefromdb;
                    $_SESSION["userlastname"] = $lastanmefromdb;
                    $stmt->close();
                    $stmt = $conn->prepare("SELECT bgcolor, txtcolor FROM vpuserprofiles WHERE userid = ?");
					$stmt->bind_param("i", $_SESSION["userid"]);
					$stmt->bind_result($bgcolorfromdb, $txtcolorfromdb);
					$stmt->execute();
					if($stmt->fetch()){
						$_SESSION["usertxtcolor"] = $txtcolorfromdb;
						$_SESSION["userbgcolor"] = $bgcolorfromdb;
					} else {
						$_SESSION["usertxtcolor"] = "#2e3440";
						$_SESSION["userbgcolor"] = "#b22222";
					}
					$stmt->close();
                    //kasutaja profiil tausta ja teksti varv
                    #$_SESSION["userbgcolor"] = "#2e3440";
                    #$_SESSION["usertxtcolor"] = "#b22222";
                    $conn->close();
                    $result = "ok";
                    header("Location: home.php");
                    exit();
                } else {
                    $result = "Vale parool";
                }
            } else {
                $result = "Kasutajat pole olemas.";
            }
        } else {
            $result = $stmt->error;
        }

        $stmt->close();
        $conn->close();
        return $result;
    }


    function storeuserprofile($description, $bgcolor, $txtcolor){
        $result = null;
        $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT vpuserprofiles_id FROM vpuserprofiles WHERE userid = ?");
		echo $conn->error;
		$stmt->bind_param("i", $_SESSION["userid"]);
        $stmt->execute();
        if($stmt->fetch()){
			$stmt->close();
			$stmt= $conn->prepare("UPDATE vpuserprofiles SET description = ?, bgcolor = ?, txtcolor = ? WHERE userid = ?");
			echo $conn->error;
			$stmt->bind_param("sssi", $description, $bgcolor, $txtcolor, $_SESSION["userid"]);
		} else {
			$stmt->close();
			$stmt = $conn->prepare("INSERT INTO vpuserprofiles (userid, description, bgcolor, txtcolor) VALUES(?,?,?,?)");
			echo $conn->error;
			$stmt->bind_param("isss", $_SESSION["userid"], $description, $bgcolor, $txtcolor);
		}
        if($stmt->execute()){
            $result = "ok";
        }else{
            $result = $result = $stmt->error;
            echo $result;
        }
        $stmt->close();
        $conn->close();
        return $result;
    }

	function readuserdescription(){
		$result = null;
        $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT description FROM vpuserprofiles WHERE userid = ?");
        echo $conn->error;
        $stmt->bind_param("i", $_SESSION["userid"]);
        $stmt->bind_result($descriptionfromdb);
        $stmt->execute();
        if($stmt->fetch()){
            $result = $descriptionfromdb;
        }else{
            $result = $conn->error;
        }
        $stmt->close();
        $conn->close();
        return $result;
	}

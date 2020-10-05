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
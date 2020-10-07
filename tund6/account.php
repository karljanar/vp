<?php
    $username = "";
    require("header.php");
    require("fnc_common.php");
    require("fnc_user.php");
    $firstnameerror = "";
    $lastnameerror = "";
    $emailerror = "";
    $passworderror = "";
    $passwordmatcherror = "";
    $gendererror = "";
    $birthdateerror = "";
    $birthdayerror = "";
    $birthmontherror = "";
    $birthyearerror = "";
    $firstname = "";
    $lastname = "";
    $email = null;
    $gender = "";
    $result = "";
    $notice = "";
    $birthdate = null;
    $birthday = null;
    $birthmonth = null;
    $birthyear = null;
    $monthnameset = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];

    if(isset($_POST["registersubmit"])){
        if(!empty($_POST["firstnameinput"])){
            $firstname = test_input($_POST["firstnameinput"]);
        } else {
            $firstnameerror = "Sisestage eesnimi.";
        }
        if(!empty($_POST["lastnameinput"])){
            $lastname = test_input($_POST["lastnameinput"]);  
        } else{
            $lastnameerror = "Sisestage perekonnanimi.";
        }
        if(!empty($_POST["emailinput"])){
            $email = test_input($_POST["emailinput"]);
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo("$email is a valid email address");
              } else {
                $emailerror = "Sisestage reaalne e-post. ";
              }
        } else{
            $emailerror .= "Sisestage e-post.";
        }
        if(isset($_POST["birthdayinput"])){
            $birthday = intval($_POST["birthdayinput"]);
        } else {
            $birthdayerror = "Palun vali sünnikuupäev!";
        }
        if(isset($_POST["birthmonthinput"])){
            $birthmonth = intval($_POST["birthmonthinput"]);
        } else {
            $birthmontherror = "Palun vali sünnikuu!";
        }
        if(isset($_POST["birthyearinput"])){
            $birthyear = intval($_POST["birthyearinput"]);
        } else {
            $birthyearerror = "Palun vali sünni aasta!";
        }
        if(empty($birthdayerror) and empty($birthmontherror) and empty($birthyearerror)){
            if(checkdate($birthmonth, $birthday, $birthyear)){
                $tempdate = new DateTime($birthyear ."-" .$birthmonth ."-" .$birthday);
                $birthdate = $tempdate->format("Y-m-d");
            } else {
                $birthdateerror = "Kontrollige kuupäeva.";
            }
        }
        if(!empty($_POST["genderinput"])){
            $gender = intval($_POST["genderinput"]);
        } else{
            $gendererror = "Sisestage sugu.";
        }
        if(strlen($_POST["passwordinput"]) < 8){
            $passworderror = "Liiga lühike parool.";
        }
        if(($_POST["passwordinput"]) != ($_POST["passwordsecondaryinput"])){
            $passwordmatcherror = "Paroolid ei kattu.";
        }
        if(empty($firstnameerror) and empty($lastnameerror) and empty($emailerror) and empty($birthdayerror) and empty($birthmontherror) and empty($birthyearerror) and empty($birthdateerror) and empty($passworderror) and empty($passwordmatcherror) and empty($gendererror)){
            $result = signup($firstname, $lastname, $email, $gender, $birthdate, $_POST["passwordinput"]);
            //$result = "done";
            if($result == "ok"){
                $notice = "Kasutaja on loodud!";
                $firstname = "";
                $lastname = "";
                $gender = "";
                $birthdate = null;
                $birthday = null;
                $birthmonth = null;
                $birthyear = null;
                $email = null;
            } else {
                $notice = "Kahjuks tekkis tehniline viga: " .$result;
            }
            
        }
    }
?>

    .register {
        float:left;
        color: whitesmoke;
        text-align: justify;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 18px;
    }
        </style>
    </head>
    <body>
    <img src="img/vp_banner.png" alt="Veebiproge kursuse logo." class="center">
    <hr>
    <div class="topnav">
        <a href="page.php">Avaleht</a>
        <a class="active" href="account.php">Registreeri</a>
    </div>
    <hr>
    <form class="register" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label>Eesnimi: </label>
        <input type="text" name="firstnameinput" id="firstnameinput" value="<?php echo $firstname; ?>">
        <span style="color:#ff0000"><?php echo $firstnameerror; ?></span><br>
        <label>Perekonnanimi: </label>
        <input type="text" name="lastnameinput" id="lastnameinput" value="<?php echo $lastname; ?>">
        <span style="color:#ff0000"><?php echo $lastnameerror; ?></span><br>
        <label>E-post: </label>
        <input type="email" name="emailinput" id="emailinput" value="<?php echo $email; ?>">
        <span style="color:#ff0000"><?php echo $emailerror; ?></span><br>
        <label for="birthdayinput">Sünnipäev: </label>
		  <?php
			echo '<select name="birthdayinput" id="birthdayinput">' ."\n";
			echo '<option value="" selected disabled>päev</option>' ."\n";
			for ($i = 1; $i < 32; $i ++){
				echo '<option value="' .$i .'"';
				if ($i == $birthday){
					echo " selected";
				}
				echo ">" .$i ."</option> \n";
			}
			echo "</select> \n";
		  ?>
	    <label for="birthmonthinput">Sünnikuu: </label>
        <?php
            echo '<select name="birthmonthinput" id="birthmonthinput">' ."\n";
            echo '<option value="" selected disabled>kuu</option>' ."\n";
            for ($i = 1; $i < 13; $i ++){
                echo '<option value="' .$i .'"';
                if ($i == $birthmonth){
                    echo " selected";
                }
                echo ">" .$monthnameset[$i - 1] ."</option> \n";
            }
            echo "</select> \n";
        ?>
        <label for="birthyearinput">Sünniaasta: </label>
        <?php
            echo '<select name="birthyearinput" id="birthyearinput">' ."\n";
            echo '<option value="" selected disabled>aasta</option>' ."\n";
            for ($i = date("Y") - 15; $i >= date("Y") - 110; $i --){
                echo '<option value="' .$i .'"';
                if ($i == $birthyear){
                    echo " selected";
                }
                echo ">" .$i ."</option> \n";
            }
            echo "</select> \n";
        ?>
        <br>
        <span style="color:#ff0000"><?php echo $birthdateerror ." " .$birthdayerror ." " .$birthmontherror ." " .$birthyearerror; ?></span><br>
        <label>Sugu: </label>
        <input type="radio" name="genderinput" id="gendermale" value="1" <?php if($gender == "1"){echo " checked";}?>>
        <label for="gendermale">Mees</label>
        <input type="radio" name="genderinput" id="genderfemale" value="2" <?php if($gender == "2"){echo " checked";}?>>
        <label for="genderfemale">Naine</label>
        <span style="color:#ff0000"><?php echo $gendererror; ?></span><br>
        <label>Parool: </label>
        <input type="password" name="passwordinput" id="passwordinput" placeholder="parool">
        <span style="color:#ff0000"><?php echo $passworderror; ?></span><br>
        <label>Korrake parooli: </label>
        <input type="password" name="passwordsecondaryinput" id="passwordsecondaryinput" placeholder="parool">
        <span style="color:#ff0000"><?php echo $passwordmatcherror; ?></span><br>
        
        <input type="submit" name="registersubmit" id="registersubmit" value="Registreeri">
        <p><?php echo "&nbsp; &nbsp; &nbsp;" .$notice; ?></p>
    </form>
</body>
</html>

<?php
    require("usesession.php");
    $username = $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"];
    require("header.php");
    require("fnc_common.php");
    require("fnc_user.php");
    $database = 'if20_karljanar_ki_1';
    $notice = "";
    $userdescription = readuserdescription(); //edaspidi pyyab andmebaasist lugeda, kui oleams, kasutab seda 
    if(isset($_POST["profilesubmit"])){
        $description = test_input($_POST["descriptioninput"]);
        $result = storeuserprofile($description, $_POST["bgcolorinput"], $_POST["txtcolorinput"]);
        //peaks tulema ok v error
        if($result == "ok"){
            $notice = "Kasutaja profiil on salvestatud.";
            $_SESSION["userbgcolor"] = $_POST["bgcolorinput"];
            $_SESSION["usertxtcolor"] = $_POST["txtcolorinput"];
            header("Refresh:0");
        }else{
            $notice = "Profilli salvestamine ebaõnnestus.".$result;
        }
    }

?>  
    <hr>
    <form class="main" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="descriptioninput">Enda tutvustus. </label>
        <br>
        <textarea name="descriptioninput" id="descriptioninput" rows="10" cols="80" placehodler="Minu tutvustus ..."><?php echo $userdescription; ?></textarea>
        <br>
        <label for="bgcolorinput">Minu taustavarv: </label>
        <input type="color" name="bgcolorinput" id="bgcolorinput" value="<?php echo $_SESSION["userbgcolor"]; ?>">
        <br>
        <label for="txtcolorinput">Minu tekstivarv: </label>
        <input type="color" name="txtcolorinput" id="txtcolorinput" value="<?php echo $_SESSION["usertxtcolor"]; ?>">
        <br>
        <input type="submit" name="profilesubmit" value="Salvesta profiil">
        <span><?php echo $notice;?></span>
    </form>
</body>
</html>
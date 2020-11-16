<?php
    session_start();
    require("fnc_common.php");
    require("fnc_user.php");
    require("../../config.php");
    $emailerror = "";
    $passworderror = "";
    $email = null;
    $result = "";
    $notice = "";
    $fulltimenow = date("H:i:s");
    $currentyear = date("Y");
    $currentdate = date("d");
    $hournow = date("H");
    $partofday = "";
    $weekdaynameset = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
    $monthnameset = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
    //echo $weekdaynameset[1];
    $weekdaynow = date("N");
    $monthnamenow = date("n");
    if($hournow <= 7 and $hournow >= 24){
        $partofday = "uneaeg";
    }
    if($hournow >= 8 and $hournow <= 18){
        $partofday = "akadeemiline aeg";
    }
    if($hournow > 18 and $hournow <= 20){
        $partofday = "trenni aeg";
    }
    if($hournow > 20 and $hournow < 22){
        $partofday = "pela aeg";
    }
    if($hournow >= 22 and $hournow < 24){
        $partofday = "ettevalmistus järgnevaks päevaks";
    }
    //semestri kulg
    $semesterstart = new DateTime("2020-8-31");
    $semesterend = new DateTime("2020-12-13");
    $semesterduration = $semesterstart->diff($semesterend);
    $semesterdurationdays = $semesterduration->format("%r%a");
    $today = new DateTime("now");
    $unidays = "";
    if($semesterstart <= $today and $semesterend >= $today){
        $unidays = "Semester on täies hoos.";
    }
    else{
        $unidays = "Praegu semester ei käi.";
    }
    $semesterdurationdaysfromnow = $today->diff($semesterend);
    $semesterdurationdaysfromnowdays = $semesterdurationdaysfromnow->format("%r%a");
    $completedsemester = $semesterstart->diff($today);
    $dayscompletedsemester = $completedsemester->format("%r%a");
    $semestercompletion = round(($dayscompletedsemester / $semesterdurationdays) * 100, 2);
    if($semestercompletion >= 100){
        $semestercompletion = 100;
    }
    elseif ($semestercompletion <= 0){
        $semestercompletion = 0;
    }
    //loeme kataloogist piltide nimekirja.
    $allfiles = scandir("vp_pics/");
    $picfiles = array_slice($allfiles, 2);
    $imghtml = "";
    $piccount = count($picfiles);
    $picnum = mt_rand(0, ($piccount - 1));
    /*for($i = 0;$i < $piccount; $i++){
        $imghtml .= '<img src="vp_pics/'. $picfiles[$i] .'" alt="pildid TLUst">';
    }*/
    $imghtml ='<img src="vp_pics/'. $picfiles[$picnum] .'" alt="pildid TLUst" class="center">';
    if(isset($_POST["loginsubmit"])){
        $email = filter_var(($_POST["emailinput"]), FILTER_SANITIZE_STRING);
        if(!empty($_POST["emailinput"]) and filter_var($email, FILTER_VALIDATE_EMAIL)){
            $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        } else{
            $emailerror .= "Sisestage e-post.";
        }
        if(empty($_POST["passwordinput"]) or (strlen($_POST["passwordinput"]) < 8)){
            $passworderror = "Sisestage parool.";
        }
        if(empty($passworderror) and empty($emailerror)){
            $result = signin($email, $_POST["passwordinput"]);
            if($result != "ok"){
                $notice .= 'Tekkis viga! '. $result;
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link rel='icon' href='img/vp_logo_small.png' type='image/x-icon' >
    <title>Veebiproge</title>
    <style>
        <?php 
            echo "body {\n";
            if(isset($_SESSION["userbgcolor"])){
                echo "\t \t background-color:" .$_SESSION["userbgcolor"] .";\n";
            }else{
                echo "\t \t background-color: #2e3440; \n";
            }
            echo "\t \t background-repeat: no-repeat; \n";
            echo "\t \t background-size: auto; \n";
            if(isset($_SESSION["usertxtcolor"])){
                echo "\t \t color:" .$_SESSION["usertxtcolor"] .";\n";
            }else{
                echo "\t \t color: #f5f5f5; \n";
            }
            echo "\t \t font-family: Arial, Helvetica, sans-serif; \n";
            echo "\t \t }\n";
            ?>

        .topnav {
            <?php 
            if(isset($_SESSION["userbgcolor"])){
                echo "background-color:" .$_SESSION["userbgcolor"] .";\n";
            }else{
                echo "background-color: #2e3440; \n";
            };?>
            overflow: hidden;
            text-align: center;
        }
        .topnav a {
            float: none;
            <?php
            if(isset($_SESSION["usertxtcolor"])){
                echo "color:" .$_SESSION["usertxtcolor"] .";\n";
            }else{
                echo "color: #f5f5f5; \n";
            }
            ?>
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }
        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }
        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 80%;
        }
        
        .main {
        float: none;
        <?php
        if(isset($_SESSION["usertxtcolor"])){
                echo "\t \t color:" .$_SESSION["usertxtcolor"] .";\n";
            }else{
                echo "\t \t color: #f5f5f5; \n";
            }
            ?>
        text-align: center;
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
        <a href="account.php">Registreeri</a>
    </div>
    <hr>
    <div class="main">
        <p>Leht avati: <?php echo $weekdaynameset[$weekdaynow-1].", ". $currentdate.'. '.$monthnameset[$monthnamenow-1].' '.$currentyear.', kell '. $fulltimenow; ?></p>
        <p><?php echo "Parajasti on ".$partofday."."; ?></p>
        <p><?php echo $unidays." Läbitud on ".$semestercompletion."% semestrist.";?></p>
        <p><?php echo "Semester kestab kokku ".$semesterdurationdays." päeva.";?></p>
        <p><?php echo "Semestri lõpuni on ".$semesterdurationdaysfromnowdays." päeva.";?></p>
        <p><?php echo "Praeguseks on semester kestnud ".$dayscompletedsemester." päeva.";?></p>
    </div>
    <form class="main" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label>E-post: </label> 
        <input type="email" name="emailinput" id="emailinput" value="<?php echo $email; ?>">
        <span style="color:#ff0000"><?php echo $emailerror; ?></span><br>
        <label>Parool: </label>
        <input type="password" name="passwordinput" id="passwordinput" placeholder="parool">
        <span style="color:#ff0000"><?php echo $passworderror; ?></span><br>
        <input type="submit" name="loginsubmit" id="loginsubmit" value="Logi sisse">
        <p><?php echo "&nbsp; &nbsp; &nbsp;" .$notice; ?></p>
    </form>
    <img src="img/ivo.jpg" alt="Crocs" width="250" height="300">
    <hr>
    <?php echo $imghtml; ?>
    <hr>

</body>
</html>
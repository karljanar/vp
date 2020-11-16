<?php
$username = "";
require("header.php");
require("fnc_common.php");
require("fnc_user.php");
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
    if(!empty($_POST["emailinput"]) and filter_var(($_POST["emailinput"]), FILTER_VALIDATE_EMAIL)){
        $email = test_input($_POST["emailinput"]);
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

    .time {
        float: left;
        color: whitesmoke;
        text-align: justify;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 20px;
    }
    .login {
        float:right;
        color: whitesmoke;
        text-align: justify;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 18px;
        display: inline-block;
    }
    </style>
    </head>
<body>
    <img src="img/vp_banner.png" alt="Veebiproge kursuse logo." class="center">
    <hr>
    <div class="topnav">
        <a class="active" href="page.php">Avaleht</a>
        <a href="account.php">Registreeri</a>
    </div>
    <hr>
    <div class="time">
        <p>Leht avati: <?php echo $weekdaynameset[$weekdaynow-1].", ". $currentdate.'. '.$monthnameset[$monthnamenow-1].' '.$currentyear.', kell '. $fulltimenow; ?></p>
        <p><?php echo "Parajasti on ".$partofday."."; ?></p>
        <p><?php echo $unidays." Läbitud on ".$semestercompletion."% semestrist.";?></p>
        <p><?php echo "Semester kestab kokku ".$semesterdurationdays." päeva.";?></p>
        <p><?php echo "Semestri lõpuni on ".$semesterdurationdaysfromnowdays." päeva.";?></p>
        <p><?php echo "Praeguseks on semester kestnud ".$dayscompletedsemester." päeva.";?></p>
    </div>
    <form class="login" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label>E-post: </label> 
        <input type="email" name="emailinput" id="emailinput" value="<?php echo $email; ?>">
        <span style="color:#ff0000"><?php echo $emailerror; ?></span><br>
        <label>Parool: </label>
        <input type="password" name="passwordinput" id="passwordinput" placeholder="parool">
        <span style="color:#ff0000"><?php echo $passworderror; ?></span><br>
        <input type="submit" name="loginsubmit" id="loginsubmit" value="Logi sisse">
        <p><?php echo "&nbsp; &nbsp; &nbsp;" .$notice; ?></p>
    </form>
    <?php echo $imghtml; ?>
    <hr>
</body>
</html>
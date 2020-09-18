<?php
require("../../config.php");
require("header.php");
$fulltimenow = date("H:i:s");
$currentyear = date("Y");
$currentdate = date("d");
$hournow = date("H");
$partofday = "";
$weekdaynameset = ["esmaspäeval", "teisipäeval", "kolmapäeval", "neljapäeval", "reedel", "laupäeval", "pühapäeval"];
$monthnameset = ["jaanuaril", "veebruaril", "märtsil", "aprillil", "mail", "juunil", "juulil", "augustil", "septembril", "oktoobril", "novembril", "detsembril"];
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
for($i = 0;$i < $piccount; $i++){
    $imghtml .= '<img src="vp_pics/'. $picfiles[$i] .'" alt="pildid TLUst">';
}

?>
    .time {
        float: none;
        color: whitesmoke;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 20px;
    }
    </style>
    </head>
    <body>
    <img src="img/vp_banner.png" alt="Veebiproge kursuse logo.">
    <div class="topnav">
        <a class="active" href="home.php">Kodu</a>
        <a href="writethoughts.php">Kirjuta mõtteid</a>
        <a href="thoughts.php">Loe mõtteid</a>
        <a href="https://github.com/karljanar/vp">GitHub</a>
    </div>
    <h1><?php echo $username; ?>i Probleem </h1>
    <p>Särkides ja värkides pole probleemi!</p>
    <hr>
    <div class="time">
        <p>Leht avati: <?php echo $weekdaynameset[$weekdaynow-1].", ". $currentdate.'. '.$monthnameset[$monthnamenow-1].', '.$currentyear.' aastal, kell '. $fulltimenow; ?></p>
        <p><?php echo "Parajasti on ".$partofday."."; ?></p>
        <p><?php echo $unidays." Läbitud on ".$semestercompletion."% semestrist.";?></p>
        <p><?php echo "Semester kestab kokku ".$semesterdurationdays." päeva.";?></font></p>
        <p><?php echo "Semestri lõpuni on ".$semesterdurationdaysfromnowdays." päeva.";?></p>
        <p><?php echo "Praeguseks on semestris läbitud ".$dayscompletedsemester." päeva.";?></p>
    </div>
    <hr>
    <p>Leht loodud veebiproge kursuse raames <a href="https://www.tlu.ee/dt" style="color:deepskyblue">TLU Digitehnoloogiate Instituudis.</a></p>
    <img src="les.jpg" alt="Esimene pilt netis.">
    <p><font size="5">Siin on kajastatud esimene pilt, mis laeti internetti <br>ning lehe taustaks on täiesti lambi värv, mis käib kokku minu firefox css themega.</font></p>
    <p>Aega läks, aga lõpuks sai serverile ligi.</p>
    <hr>
    <?php echo $imghtml; ?>
    <hr>
</body>
</html>
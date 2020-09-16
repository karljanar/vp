<?php
    $username = "Janar";
    $fulltimenow = date("d.m.Y H:i:s");
    $hournow = date("H");
    $partofday = "";
    $weekdaynameset = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
    $monthnameset = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
    //echo $weekdaynameset[1];
    $weekdaynow = date("N");
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

?>
<!DOCTYPE html><!--browseri jaoks, et kiirelt saaks aru, millega  on tehu-->
<html lang="et"><!--vajalik nt search enginile, et n'idata mis riigi lehega nt tegu-->
<head>
    <meta charset="utf-8">
    <title><?php echo $username; ?> ehitab lehte</title>
    <style>
         body {
             background-color: #2e3440;
             background-repeat: no-repeat;
             background-size: auto;
             color:whitesmoke;
         }
    </style> 
</head>
<body>
    <h1><?php echo $username; ?>i Probleem </h1>
    <p>Särkides ja värkides pole probleemi!</p>
    <p style="color:firebrick"><font size="5">Leht avati: <?php echo $weekdaynameset[$weekdaynow-1].", ". $fulltimenow; ?></font></p>
    <p style="color:firebrick"><font size="5"><?php echo "Parajasti on ".$partofday."."; ?></font></p>
    <p style="color:firebrick"><font size="5"><?php echo $unidays." Läbitud on ".$semestercompletion."% semestrist.";?></font></p>
    <p style="color:firebrick"><font size="5"><?php echo "Semester kestab kokku ".$semesterdurationdays." päeva.";?></font></p>
    <p style="color:firebrick"><font size="5"><?php echo "Semestri lõpuni on ".$semesterdurationdaysfromnowdays." päeva.";?></font></p>
    <p style="color:firebrick"><font size="5"><?php echo "Praeguseks on semestris läbitud ".$dayscompletedsemester." päeva.";?></font></p>
    <p>Leht loodud veebiproge kursuse raames <a href="https://www.tlu.ee/dt" style="color:deepskyblue">TLU Digitehnoloogiate Instituudis.</a></p>
    <img src="les.jpg">
    <p><font size="5">Siin on kajastatud esimene pilt, mis laeti internetti <br>ning lehe taustaks on täiesti lambi värv, mis käib kokku minu firefox css themega.</font></p>
    <p>Aega läks, aga lõpuks sai serverile ligi.</p>
    <p>Koodi asjad leitavad <a href="https://github.com/karljanar/vp" style="color:deepskyblue">GitHubis.</a></p>
</body>
</html>
<?php
    $username = "Janar";
    $fulltimenow = date("d.m.Y H:i:s");
    $hournow = date("H");
    $partofday = "lihtsalt aeg";
    if($hournow < 7){
        $partofday = "uneaeg";
    }
    if($hournow >= 8 and $hournow <= 18){
        $partofday = "akadeemiline aeg";
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
         }
    </style> 
</head>
<body>
    <h1><?php echo $username; ?>i Probleem </h1>
    <p><font size="5">Leht avati: <?php echo $fulltimenow; ?></font></p>
    <p style="color:green">Särkides ja värkides pole probleemi!</p>
    <p style="color:springgreen">Leht loodud veebiproge kursuse raames <a href="https://www.tlu.ee/dt" style="color: snow">TLU Digitehnoloogiate Instituudis.</a></p>
    <img src="les.jpg">
    <p style="color:firebrick"><font size="5">Siin on kajastatud esimene pilt, mis laeti internetti <br>ning lehe taustaks on täiesti lambi värv.</font></p>
    <p style="color:greenyellow">Aega läks, aga lõpuks sai serverile ligi.</p>
    <p><?php echo "Parajasti on ".$partofday."."; ?></p>
</body>
</html>
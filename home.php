<?php
    
    require("usesession.php");
    require("header.php");
    require("fnc_photo.php");
    
    $username = $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"];
    
    //require("Generic_class.php");
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
    //logib valja
    //$myfirstclass = new Generic(8)
    //echo $myfirstclass->$yoursecret;
    //$myfirstclass->showValue();
    //unset($myfirstclass);
    

    //tegeleme cookies
    //setcookie peab olema enne html algust
    //maarame 1nime,2 vaartus, eluiga(8 oopaeva), kataloog default /, domeen, http v https(vajalik sertifikaat), httponly default false - kas saab ligi ainult labi veebiserveri, 
    setcookie("vpvisitor", $username, time() + (86400 * 8), "/~karlkin/", "greeny.cs.tlu.ee", isset($_SERVER["HTTPS"]), true);
    $fileuploaddir_thumb = "photoupload_thumb/";
    $newestImage = latestImage();
?>
    <hr>
    <div class="thumbgallery">
        <p>Pildike</p>
        <p><?php echo $newestImage; ?></p>
    </div>
    <div class="main">
        <h1><?php echo $username; ?> Probleem </h1>
        <p>Särkides ja värkides pole probleemi!</p>
        <p>Leht loodud veebiproge kursuse raames <a href="https://www.tlu.ee/dt" style="color:deepskyblue">TLU Digitehnoloogiate Instituudis.</a></p>
    </div>
    
    <div class="main">
        <p>Leht avati: <?php echo $weekdaynameset[$weekdaynow-1].", ". $currentdate.'. '.$monthnameset[$monthnamenow-1].' '.$currentyear.', kell '. $fulltimenow; ?></p>
        <p><?php echo "Parajasti on ".$partofday."."; ?></p>
        <p><?php echo $unidays." Läbitud on ".$semestercompletion."% semestrist.";?></p>
        <p><?php echo "Semester kestab kokku ".$semesterdurationdays." päeva.";?></p>
        <p><?php echo "Semestri lõpuni on ".$semesterdurationdaysfromnowdays." päeva.";?></p>
        <p><?php echo "Praeguseks on semester kestnud ".$dayscompletedsemester." päeva.";?></p>
        <p><?php $myfirstclass;?></p> 
    </div>
    <hr>
    <?php 
        if(count($_COOKIE) > 0){
            echo "<p>Küpsised on lubatud! Leidsin: " .count($_COOKIE) ." küpsist.</p> \n";
            var_dump($_COOKIE);
        } else {
            echo "<p>Küpsised pole lubatud!</p> \n";
        }
        if(isset($_COOKIE["vpvisitor"])){
            echo "<p>Küpsisest selgus viimase külastaja nimi: " .$_COOKIE["vpvisitor"] .". \n";
        } else {
            echo "<p>Viimase kasutaja nime ei leitud!</p> \n";
        }
    ?>
    <hr>
    <?php echo $imghtml; ?>
    <hr>
     <div style="width:100%;height:0px;position:relative;padding-bottom:75.000%;"><iframe src="https://streamable.com/e/4jljlx?loop=0" frameborder="0" width="100%" height="100%" allowfullscreen style="width:100%;height:100%;position:absolute;left:0px;top:0px;overflow:hidden;"></iframe></div>
</body>
</html>
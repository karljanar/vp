<?php
    require("usesession.php");
    $tolink = '<script src="javascript/newsedit.js" defer></script>' ."\n";
	$tolink .= "\t" .'<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>' ."\n";
	$tolink .= "\t" .'<script>tinymce.init({selector:"textarea#newsinput", plugins: "link", menubar: "edit",});</script>' ."\n";
    require("header.php");
    require("fnc_common.php");
    require("Photoupload_class.php");
    $newsid = intval($_REQUEST["news"]);
    require("fnc_news.php");
    $inputerror = "";
	$notice = "";
	$news = null;
	$newstitle = null;
	$date = date('Y-m-d');
	$current_date = strtotime($date);
	$expire = date("Y-m-d",$current_date+=2592000);
	$fileuploaddir_orig = "photoupload_orig/";
	$fileuploaddir_news = "newsphoto/";
	$photomaxw = 600;
	$photomaxh = 400;
	$alttext = null;
	$filenameprefix = "vpnews_";
	$watermark = 'img/overlay.png';
    $news = changeNews($newsid);
    //$news = htmlspecialchars_decode($news);
    if(isset($_POST["newseditsubmit"])){
        
		if(strlen($_POST["altinput"]) == 0){
			$inputerror = "Sisestage pildi kirjeldus!";
        } else {
			$alttext = test_input($_POST["altinput"]);
		}
		if(strlen($_POST["newstitleinput"]) == 0){
			$inputerror = "Sisestage pealkiri!";
		} else {
			$newstitle = test_input($_POST["newstitleinput"]);
		}
		if(strlen($_POST["newsinput"]) == 0){
			$inputerror .= "Uudise sisu on puudu!";
		} else {
			$text = test_input($_POST["newsinput"]);
			//htmlspecialchars teisendab html noolsulud
			//tagasi saamiseks hymlspecialchars_decode(uudis)
        }
        echo $newsid, $alttext, $newstitle, $text;
        if(!empty($_FILES["photoinput"]["name"])){
            print_r($_FILES["photoinput"]);
            $check = getimagesize($_FILES["photoinput"]["tmp_name"]);
            if($check !== false){
                //var_dump($check);
                if($check["mime"] == "image/jpeg"){
                    $filetype = "jpg";
                }
                if($check["mime"] == "image/png"){
                    $filetype = "png";
                }
                if($check["mime"] == "image/gif"){
                    $filetype = "gif";
                }
            } else {
                $inputerror = "Valitud fail ei ole pilt!";
            }
            
            //ega pole liiga suur fail
            $timestamp = microtime(1) * 10000;
            $filename = $filenameprefix .$timestamp ."." .$filetype;
            $myphoto = new Photoupload($_FILES["photoinput"], $filetype);
        
            $myphoto->resizePhoto($photomaxw, $photomaxh, true);
            $myphoto->addWatermark($watermark);
            $result = $myphoto->savePhotoFile($fileuploaddir_news .$filename);
            if($result == 1){
                $notice .= "Vähendatud pildi salvestamine õnnestus!";
            } else {
                $inputerror .= "Vähendatud pildi salvestamisel tekkis tõrge!";
            }
		

            if(empty($inputerror)){
                $nresult = storeUpdatedNews($newstitle, $text, $expire, $filename, $alttext, $newsid);
                $notice .= $nresult;
                
                   
                

            }
            unset($myphoto);
        } else {
            $filename = $news[3];
            $nresult = storeUpdatedNews($newstitle, $text, $expire, $filename, $alttext, $newsid);
            $notice .= $nresult;
        }	
		
	}

    ?>


<hr>
    <form method="POST" class="mainl" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?news=" .$newsid;?>" enctype="multipart/form-data">
        <label for="newstitleinput">Muutke pealkiri</label>
        <input id="newstitleinput" name="newstitleinput" type="text" value="<?php echo htmlspecialchars_decode($news[0]);?>"required>
        <br>
        <label for="newsinput">Muutke uudist</label>
		<br>
		<textarea id="newsinput" name="newsinput"><?php echo htmlspecialchars_decode($news[1]);?></textarea>
        <br>
		<label for="photoinput">Valige pildifail</label>
        <input id="photoinput" name="photoinput" type="file">
		<br>
        <label for="altinput">Lisage pildi lühikirjeldus / Alternatiiv tekst</label>
        <input id="altinput" name="altinput" type="text" value="<?php echo htmlspecialchars_decode($news[3]);?>">
        <br>
        <input type="submit" id="newseditsubmit" name="newseditsubmit" value="Salvesta uudis">
    </form>
<p id="notice"><?php echo $notice; 
echo $inputerror;
?></p>



<?php
    require("usesession.php");
    require("fnc_common.php");
	require("fnc_news.php");
	require("Photoupload_class.php");
    //require("Photoupload_class.php");

	$tolink = '<script src="javascript/news.js" defer></script>' ."\n";
	
	$tolink .= "\t" .'<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>' ."\n";
	$tolink .= "\t" .'<script>tinymce.init({selector:"textarea#newsinput", plugins: "link", menubar: "edit",});</script>' ."\n";
	require("header.php");
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
	
  //kas vajutati salvestusnuppu
	if(isset($_POST["newssubmit"])){
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
			$news = test_input($_POST["newsinput"]);
			//htmlspecialchars teisendab html noolsulud
			//tagasi saamiseks hymlspecialchars_decode(uudis)
		}
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
		$result = $myphoto->savePhotoFile($fileuploaddir_news .$filename);
		if($result == 1){
			$notice .= "Vähendatud pildi salvestamine õnnestus!";
		} else {
			$inputerror .= "Vähendatud pildi salvestamisel tekkis tõrge!";
		}
		
		if(empty($inputerror)){
			if(move_uploaded_file($_FILES["photoinput"]["tmp_name"], $fileuploaddir_orig .$filename)){
				$notice .= " Originaalpildi salvestamine õnnestus!";
			} else {
				$inputerror .= " Originaalpildi salvestamisel tekkis viga!";
			}
		}
		


		if(empty($inputerror)){
			$nresult = storeNews($newstitle, $news, $expire);
			if($nresult == 1){
				$notice .= " Uudis on salvesatud andmebaasi!";
			} else {
				$inputerror .= " Uudise salvestamisel tekkis tõrge!" .$nresult;
			}
			$result = storeNewsPhotoData($filename, $alttext);
			if($result == 1){
				$notice .= " Pildi info lisati andmebaasi!";
				$privacy = 1;
				$alttext = null;
			} else {
				$inputerror .= " Pildi info andmebaasi salvestamisel tekkis tõrge!";
			}
		}	
		unset($myphoto);
	}
?>

    <!--<ul>
        <li><a href="home.php">Home</a> loetelu
        </li></ul>-->
    <hr>
    <form method="POST" class="mainl" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
        <label for="newstitleinput">Sisestage pealkiri</label>
        <input id="newstitleinput" name="newstitleinput" type="text" value="<?php echo $newstitle; ?>"required>
        <br>
        <label for="newsinput">Kirjutage uudis</label>
		<br>
		<textarea id="newsinput" name="newsinput" placeholder="Sisu"> <?php echo $news; ?> </textarea>
        <br>
		<label for="photoinput">Valige pildifail</label>
        <input id="photoinput" name="photoinput" type="file">
		<br>
        <label for="altinput">Lisage pildi lühikirjeldus / Alternatiiv tekst</label>
        <input id="altinput" name="altinput" type="text" placeholder="Pildi lühikirjeldus ...">
        <br>
        <input type="submit" id="newssubmit" name="newssubmit" value="Salvesta uudis">
    </form>
	<p id="notice">
		<?php 
			echo $inputerror;
			echo $notice;
		?>
	</p>
    </body>
</html>


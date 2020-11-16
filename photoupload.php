<?php
    require("usesession.php");
    require("header.php");
    require("fnc_common.php");
    require("fnc_photo.php");
    require("Photoupload_class.php");

  $inputerror = "";
  $notice = "";
  $fileuploadsizelimit = 2097152;//1048576;
  $fileuploaddir_orig = "photoupload_orig/";
  $fileuploaddir_normal = "photoupload_normal/";
  $fileuploaddir_thumb = "photoupload_thumb/";
  $filename = "";
  $filenameprefix = "vp_";
  $photomaxw = 600;
  $photomaxh = 400;
  $thumbsize = 100;
  $privacy = 1;
  $alttext = null;
  $watermark = 'img/overlay.png';
  //kas vajutati salvestusnuppu
  if(isset($_POST["photosubmit"])){
	//var_dump($_POST);
	//var_dump($_FILES);
	$privacy = intval($_POST["privinput"]);
	$alttext = test_input($_POST["altinput"]);
	
	//kas on üldse pilt
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
	if($_FILES["photoinput"]["size"] > $fileuploadsizelimit){
		$inputerror .= " Valitud fail on liiga suur!";
	}
	$timestamp = microtime(1) * 10000;
	$filename = $filenameprefix .$timestamp ."." .$filetype;
	
	//kas fail on olemas
	/* if(file_exists($fileuploaddir_orig .$filename)){
		$inputerror .= " Sellise nimega fail on juba olemas!";
	} */
	
	if(empty($inputerror)){

        //votame kasutusele klassi
        $myphoto = new Photoupload($_FILES["photoinput"], $filetype);
		//muudame suurust
		//$mynewimage = resizePhoto($mytempimage, $photomaxw, $photomaxh, true);
		//failinimi
        
        $myphoto->resizePhoto($photomaxw, $photomaxh, true);
        $myphoto->addWatermark($watermark);
        //salvestame vähendatud pildi faili
        //$result = savePhotoFile($mynewimage, $filetype, $fileuploaddir_normal .$filename);
        $result = $myphoto->savePhotoFile($fileuploaddir_normal .$filename);
		if($result == 1){
			$notice .= "Vähendatud pildi salvestamine õnnestus!";
		} else {
			$inputerror .= "Vähendatud pildi salvestamisel tekkis tõrge!";
		}
		
		//pisipilt
        //$mynewimage = resizePhoto($mytempimage, $thumbsize, $thumbsize);
        $myphoto->resizePhoto($thumbsize, $thumbsize);
		$result = $myphoto->savePhotoFile($fileuploaddir_thumb .$filename);//savePhotoFile($mynewimage, $filetype, $fileuploaddir_thumb .$filename);
		if($result == 1){
			$notice .= "Pisipildi salvestamine õnnestus!";
		} else {
			$inputerror .= "Pisipildi salvestamisel tekkis tõrge!";
		}
		//kui vigu pole, salvestame originaalpildi
		if(empty($inputerror)){
			if(move_uploaded_file($_FILES["photoinput"]["tmp_name"], $fileuploaddir_orig .$filename)){
				$notice .= " Originaalpildi salvestamine õnnestus!";
			} else {
				$inputerror .= " Originaalpildi salvestamisel tekkis viga!";
			}
		}
		
		//kui vigu pole, salvestame info andmebaasi
		if(empty($inputerror)){
			$result = storePhotoData($filename, $alttext, $privacy);
			if($result == 1){
				$notice .= " Pildi info lisati andmebaasi!";
				$privacy = 1;
				$alttext = null;
			} else {
				$inputerror .= " Pildi info andmebaasi salvestamisel tekkis tõrge!";
			}
		} else {
			$inputerror .= " Tekkinud vigade tõttu pildi andmeid ei salvestatud!";
        }
        unset($myphoto);
	}
  }
?>

    <!--<ul>
        <li><a href="home.php">Home</a> loetelu
        </li></ul>-->
    <hr>
    <form method="POST" class="main" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
        <label for="photoinput">Vali pildifail</label>
        <input id="photoinput" name="photoinput" type="file">
        <br>
        <label for="altinput">Lisa pildi lühikirjeldus / Alternatiiv tekst</label>
        <input id="altinput" name="altinput" type="text" placeholder="Pildi lühikirjeldus ...">
        <br>
        <label>Määra privaatsustase</label>
        <br>  
        <input id="privinput1" name="privinput" type="radio" value="1" <?php if($privacy == 1){echo " checked";} ?>>
        <label for="privinput1">Privaatne (ise näed)</label>
        <input id="privinput2" name="privinput" type="radio" value="2" <?php if($privacy == 2){echo " checked";} ?>>
        <label for="privinput2">Sisseloginud kasutajatele</label>
        <input id="privinput3" name="privinput" type="radio" value="3" <?php if($privacy == 3){echo " checked";} ?>>
        <label for="privinput3">Avalik</label>
        <br>
        <input type="submit" name="photosubmit" value="Lae pilt üles">
    </form>
    <?php echo $inputerror;
    echo $notice;
    ?>
    </body>
</html>


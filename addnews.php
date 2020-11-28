<?php
    require("usesession.php");
    require("fnc_common.php");
    require("fnc_news.php");
    //require("Photoupload_class.php");

	$tolink = '<script src="javascript/checkfilesize.js" defer></script>' ."\n";
	$tolink = "\t" .'<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>' ."\n";
	$tolink .= "\t" .'<script>tinymce.init({selector:"textarea#newsinput", plugins: "link", menubar: "edit",});</script>' ."\n";
	require("header.php");
  	$inputerror = "";
	$notice = "";
	$news = null;
	$newstitle = null;
	$date = date('Y-m-d');
	$current_date = strtotime($date);
	$expire = date("Y-m-d",$current_date+=2592000);

	
  //kas vajutati salvestusnuppu
	if(isset($_POST["newssubmit"])){
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
		if(empty($inputerror)){
			$result = storeNews($newstitle, $news, $expire);
			if($result == 1){
				$notice .= " Uudis on salvesatud andmebaasi!";
			} else {
				$inputerror .= " Uudise salvestamisel tekkis tõrge!" .$result;
			}
		}
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


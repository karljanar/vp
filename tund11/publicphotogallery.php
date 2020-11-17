<?php
	require("usesession.php");
	require("fnc_photo.php");
	$tolink = '<link rel="stylesheet" type="text/css" href="style/gallery.css">' ."\n";
	require("header.php");
	

    $notice = "";
    $fileuploaddir_orig = "photoupload_orig/";
    $fileuploaddir_normal = "photoupload_normal/";
	$fileuploaddir_thumb = "photoupload_thumb/";
	
	$gallerypagelimit = 3;
	$page = 1;
	$photocount = countPublicPhotos(2);



	if(!isset($_GET["page"]) or $_GET["page"] < 1){
		$page = 1;
	}elseif((intval($_GET["page"]) - 1) * $gallerypagelimit >= $photocount){

		$page = ceil($photocount/$gallerypagelimit);
	}else{
		$page = intval($_GET["page"]);
	}
	//$publicphotothumbshtml = readAllPublicPhotoThumbs(2);
	$publicphotothumbshtml = readAllPublicPhotoThumbsPage(2, $gallerypagelimit, $page);
	
  //kas vajutati salvestusnuppu

	
  
?>
    <hr>
    <h2>Fotogalerii</h2>
	<p>
	<?php 
		if($page > 1){
			echo '<span><a href="?page=' .($page - 1) .'">Eelmine leht</a></span> |' ."\n";
		}else{
			echo '<span>Eelmine leht</span> |' ."\n";
		}
		if($page * $gallerypagelimit < $photocount){
			echo '<span><a href="?page=' .($page + 1) .'">Jargmine leht</a></span>' ."\n";
		}else{
			echo '<span></span>' ."\n";
		}
		?>
	</p>
    <?php 
		echo $publicphotothumbshtml;
    ?>
	
    </body>
</html>

 

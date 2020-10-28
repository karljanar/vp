<?php
    require("usesession.php");
    require("header.php");
    //kas vajutati salvestus nuppu
    $inputerror = "";
    $fileuploadsizelimit = 1048576;
    $notice = "";
    $filename = "";
    $filenameprefix = "vp_";
    $fileuploaddir_orig = "photoupload_orig/";
    $photomaxw = 600;
    $photomaxh = 400;
    $fileuploaddir_normal = "photoupload_normal/";


    if(isset($_POST["photosubmit"])){
       //var_dump($_POST);
       //var_dump($_FILES);
       //kas on pilt
       $check = getimagesize($_FILES["photoinput"]["tmp_name"]);
        if($check !== false){
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
            $inputerror = "Valitud fail ei ole pilt. ";
        }

       //ega pole liiga suur fail
        if($_FILES["photoinput"]["size"] > $fileuploadsizelimit){
           $inputerror .= "Fail on liiga suur. ";
        }

        //genereerime faili nime

        $timestamp = microtime(1) * 10000;
        $filename = $filenameprefix .$timestamp ."." .$filetype;


       //kas fail olemas
        if(file_exists($fileuploaddir_orig .$filename)){
            $inputerror .= "See fail juba eksisteerib. ";
        }

        if(empty($inputerror)){
            //teen pildi vaiksemaks
            //loome iamge objekti ehk pikslikogu
            if($filetype == "jpg"){
                $mytempimage = imagecreatefromjpeg($_FILES["photoinput"]["tmp_name"]);
            }
            if($filetype == "png"){
                $mytempimage = imagecreatefrompng($_FILES["photoinput"]["tmp_name"]);
            }
            if($filetype == "gif"){
                $mytempimage = imagecreatefromgif($_FILES["photoinput"]["tmp_name"]);
            }
            //pildi orig suurus
            $imagew = imagesx($mytempimage);
            $imageh = imagesy($mytempimage);
            //kas laius v korgus ja leian vahendamise kordaja
            if($imagew / $photomaxw > $imageh / $photomaxh){
                $photosizeratio = $imagew / $photomaxw;
            } else {
                $photosizeratio = $imageh / $photomaxh;
            }
            //arvutan uued piirid
            $neww = round($imagew / $photosizeratio);
            $newh = round($imageh / $photosizeratio);
            //loon uue suurusega pildi objekti
            $mynewtempimage = imagecreatetruecolor($neww, $newh);
            //sailitamaks png piltide labipaistvust
            imagesavealpha($mynewtempimage, true);
            $transparentcolor = imagecolorallocatealpha($mynewtempimage, 0, 0, 0, 127);
            imagefill($mynewtempimage, 0, 0, $transparentcolor);

            imagecopyresampled($mynewtempimage, $mytempimage, 0, 0, 0, 0, $neww, $newh, $imagew, $imageh);
            
            //vahendatud pilt faili
            if($filetype == "jpg"){
                if(imagejpeg($mynewtempimage, $fileuploaddir_normal .$filename, 90)){
                    $notice .= "Vahendatud pildi salvestamine timmis. ";
                } else {
                    $notice .= "Vahendatud pildi salvestamine ebaonnestus. ";
                }
            }
            if($filetype == "png"){
                if(imagepng($mynewtempimage, $fileuploaddir_normal .$filename, 6)){
                    $notice .= "Vahendatud pildi salvestamine timmis. ";
                } else {
                    $notice .= "Vahendatud pildi salvestamine ebaonnestus. ";
                }
            }
            if($filetype == "gif"){
                if(imagegif($mynewtempimage, $fileuploaddir_normal .$filename)){
                    $notice .= "Vahendatud pildi salvestamine timmis. ";
                } else {
                    $notice .= "Vahendatud pildi salvestamine ebaonnestus. ";
                }
            }
            imagedestroy($mynewtempimage);
            imagedestroy($mytempimage);

            if(move_uploaded_file($_FILES["photoinput"]["tmp_name"], $fileuploaddir_orig .$filename)){
                $notice .= "Timmis!";
            } else {
                $notice .= "Tekkis viga!";
            }
            

        }
       
    }
?>
        .pilt {
            float: none;
            <?php
            if(isset($_SESSION["usertxtcolor"])){
                    echo "color:" .$_SESSION["usertxtcolor"] .";\n";
                }else{
                    echo "color: #f5f5f5; \n";
                }
                ?>
            text-align: left;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 18px;
        }
        </style>
    </head>
    <body>
    <img src="img/vp_banner.png" alt="Veebiproge kursuse logo." class="center">
    <hr>
    <div class="topnav">
        <a href="home.php">Kodu</a>
        <a href="writethoughts.php">Kirjuta mõtteid</a>
        <a href="thoughts.php">Loe mõtteid</a>
        <a href='listfilms.php'>Filmide nimekiri</a>
        <a href="listfilmpersons.php">Näitlejad</a>
        <a href='addfilms.php'>Lisa filme</a>
        <a href="filmrelations.php">Filmi seosed</a>
        <a href="userprofile.php">Profiil</a>
        <a class="active" href=photoupload.php>Galerii Üles</a>
        <a href="https://github.com/karljanar/vp">GitHub</a>
        <p><a href="?logout=1">Logi välja</a></p>
    </div>
    <!--<ul>
        <li><a href="home.php">Home</a> loetelu
        </li></ul>-->
    <hr>
    <form method="POST" class="pilt" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
        <label for="photoinput">Vali pildifail</label>
        <input id="photoinput" name="photoinput" type="file">
        <br>
        <label for="altinput">Lisa pildi lühikirjeldus / Alternatiiv tekst</label>
        <input id="altinput" name="altinput" type="text" placeholder="Pildi lühikirjeldus ...">
        <br>
        <label>Määra privaatsustase</label>
        <br>  
        <input id="privinput1" name="privinput" type="radio" value="1">
        <label for="privinput1">Privaatne (ainult ise)</label>
        <br>  
        <input id="privinput2" name="privinput" type="radio" value="2">
        <label for="privinput2">Sisseloginud kasutajatele</label>
        <br>  
        <input id="privinput3" name="privinput" type="radio" value="3">
        <label for="privinput3">Avalik</label>
        <br>
        <input type="submit" name="photosubmit" value="Lae pilt üles">
    </form>
    <?php echo $inputerror;
    echo $notice;
    ?>
    </body>
</html>


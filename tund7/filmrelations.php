<?php
    require("usesession.php");
    $username = $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"];
    require("header.php");
    require("fnc_filmrelations.php");
    //kas vajutati salvestus nuppu
    $genrenotice = "";
    $studionotice = "";
    $selectedfilm = "";
    $selectedgenre = "";
    $selectedstudio = "";

    if(isset($_POST["filmrelationsubmit"])){
      //$selectedfilm = $_POST["filminput"];
      if(!empty($_POST["filminput"])){
          $selectedfilm = intval($_POST["filminput"]);
      } else {
          $notice = " Vali film!";
      }
      if(!empty($_POST["filmgenreinput"])){
          $selectedgenre = intval($_POST["filmgenreinput"]);
      } else {
          $notice .= " Vali žanr!";
      }
      if(!empty($selectedfilm) and !empty($selectedstudio)){
          $notice = storenewstudiorelation($selectedfilm, $selectedstudio);
      }
    }

    if(isset($_POST[filmstudiorelationsubmit])){
        if(!empty($_POST["filminput"])){
            $selectedfilm = intval($_POST["filminput"]);
        } else {
            $notice = " Vali Stuudio!";
        }
        if(!empty($_POST["filmstudioinput"])){
            $selectedstudio = intval($_POST["filmstudioinput"]);
        } else {
            $notice .= " Vali Stuudio!";
        }
        if(!empty($selectedfilm) and !empty($selectedgenre)){
            $notice = storenewgenrerelation($selectedfilm, $selectedgenre);
        }

    }
    
    $filmselecthtml = readmovietoselect($selectedfilm);
    $filmgenreselecthtml = readgenretoselect($selectedgenre);
    $filmcompanyselecthtml = readstudioselect($selectedstudio);
?>
        .form {
        float:left;
        color: whitesmoke;
        text-align: justify;
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
        <a href='addfilms.php'>Lisa filme</a>
        <a class='active' href="filmrelations.php">Filmi seosed</a>
        <a href="userprofile.php">Profiil</a>
        <a href="https://github.com/karljanar/vp">GitHub</a>
        <p><a href="?logout=1">Logi välja</a></p>
    </div>
    <!--<ul>
        <li><a href="home.php">Home</a> loetelu
        </li></ul>-->
    <hr>
    <form class="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <?php
		echo $filmselecthtml;
		echo $filmgenreselecthtml;
	?>
	<input type="submit" name="filmrelationsubmit" value="Salvesta"><span><?php echo $genrenotice; ?></span>
    <form class="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <?php
		echo $filmselecthtml;
		echo $filmstudioselecthtml;
	?>
	<input type="submit" name="filmstudiorelationsubmit" value="Salvesta"><span><?php echo $studionotice; ?></span>
    </body>
</html>


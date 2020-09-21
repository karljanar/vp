<?php
    require("header.php");
?>

    .login {
            float: right;
            color: whitesmoke;
            text-align: justify;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 18px;
        }
    .register {
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
        <a href="addfilms.php">Lisa filme</a>
        <a class="active" href="account.php">Kasutaja</a>
        <a href="https://github.com/karljanar/vp">GitHub</a>
    </div>
    <hr>
    <form class="login" method="POST">
        <label>Kasutajanimi: </label>
        <input type="text" name="unamesubmit" placeholder="kasutajanimi">
        <br>
        <label>Parool: </label>
        <input type="password" name="pswsubmit" placeholder="parool">
        <br>
        <input type="submit" name="accsubmit" value="Sisene">
    </form>
    <form class="register" method="POST">
        <label>Kasutajanimi: </label>
        <input type="text" name="unamesubmit" placeholder="kasutajanimi">
        <br>
        <label>Parool: </label>
        <input type="password" name="pswsubmit" placeholder="parool">
        <br>
        <label>Korrake parooli: </label>
        <input type="password" name="pswsubmitcheck" placeholder="parool">
        <br>
        <label>Sugu: </label>
        <input type="radio" id="male" name="gender" value="male">
        <label for="male">Mees</label><br>
        <input type="radio" id="female" name="gender" value="female">
        <label for="female">Naine</label><br>
        <input type="radio" id="other" name="gender" value="other">
        <label for="other">Muu</label> 
    </form>
</body>
</html>

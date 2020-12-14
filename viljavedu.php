<?php
    require("header.php");
    //require("usesession.php");
    require("fnc_vili.php");
    require("fnc_common.php");
    $inputerror = "";
    $emptym = null;
    $notice = "";
    $selected = "";
    $ninputerror = "";
    $nnotice = "";


    if(isset($_POST["carsubmit"])){
        if(empty($_POST["regnuminput"])){
            $inputerror .= "Sisestage auto registrinumber";
        } else {
            $regnum = test_input($_POST["regnuminput"]);
        }
        if(empty($_POST["siseneminput"])){
            $inputerror .= "Sisestage auto sisenemismass";
        } else {
            $sissm = test_input($_POST["siseneminput"]);
        }
        if(!empty($_POST["emptyminput"])){
            $emptym = test_input($_POST["emptyminput"]);
        }
        if(empty($inputerror)){
            $result = saveCar($regnum, $sissm, $emptym);
            if($result == 1){
                $notice .= "Salvestatud!";
            } else {
                $inputerror .= "Salvestamisel tekkis torge. " .$result;
            }
        }

    }

    if(isset($_POST["updatecarsubmit"])){
        if(!empty($_POST["carinput"])){
            $selectedcar = intval($_POST["carinput"]);
        } else {
            $ninputerror .= " Vali masin!";
        }
        if(!empty($_POST["emptymupinput"])){
            $selectedemptym = test_input($_POST["emptymupinput"]);
        } else {
            $ninputerror .= "Lisa tuhimass!";
        }
        if(!empty($selectedcar) and !empty($selectedemptym)){
            $nnotice = updateCar($selectedcar, $selectedemptym);
        }
    }

    $carselecthtml = readcartoselect($selected);
    ?>

    <hr>
    <form method="POST" class="mainl" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
        <label for="regnuminput">Sisestage registrinumber</label>
        <input id="regnuminput" name="regnuminput" type="text" required>
        <br>
        <label for="siseneminput">Sisestage sisenemismass</label>
        <input id="siseneminput" name="siseneminput" type="text" required>
        <br>
        <label for="emptyminput">Sisestage tühimass</label>
        <input id="emptyminput" name="emptyminput" type="text">
        <br>
        <input type="submit" id="carsubmit" name="carsubmit" value="Salvesta vedu">
    </form>
    <br>
    <?php
        echo $inputerror;
        echo $notice;
        ?>
    <hr>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label>Vali auto: </label>
        <?php
            echo $carselecthtml;
        ?>
        <br>
        <label for="emptymupinput">Sisestage tühimass</label>
        <input id="emptymupinput" name="emptymupinput" type="text">
        <br>
        <input type="submit" name="updatecarsubmit" value="Salvesta"><span></span>
        <?php 
            echo $ninputerror;
            echo $nnotice;
            ?>
    </form> 
    <hr>
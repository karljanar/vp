<?php
    $database = "if20_karljanar_ki_1";

    function readmovietoselect($selected){
        $notice = "<p>Kahjuks filme ei leitud!</p> \n";
        $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT movie_id, title FROM movie");
        echo $conn->error;
        $stmt->bind_result($idfromdb, $titlefromdb);
        $stmt->execute();
        $films = "";
        while($stmt->fetch()){
            $films .= '<option value="' .$idfromdb .'"';
            if(intval($idfromdb) == $selected){
                $films .=" selected";
            }
            $films .= ">" .$titlefromdb ."</option> \n";
        }
        if(!empty($films)){
            $notice = '<select name="filminput" id="filminput">' ."\n";
            $notice .= '<option value="" selected disabled>Vali film</option>' ."\n";
            $notice .= $films;
            $notice .= "</select> \n";
        }
        $stmt->close();
        $conn->close();
        return $notice;
    }
    
    function readgenretoselect($selected){
        $notice = "<p>Zanre ei leitud!</p> \n";
        $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT genre_id, genre_name FROM genre");
        echo $conn->error;
        $stmt->bind_result($idfromdb, $genrefromdb);
        $stmt->execute();
        $genres = "";
        while($stmt->fetch()){
            $genres .= '<option value="' .$idfromdb .'"';
            if(intval($idfromdb) == $selected){
                $genres .=" selected";
            }
            $genres .= ">" .$genrefromdb ."</option> \n";
        }
        if(!empty($genres)){
            $notice = '<select name="filmgenreinput">' ."\n";
            $notice .= '<option value="" selected disabled>Vali žanr</option>' ."\n";
            $notice .= $genres;
            $notice .= "</select> \n";
        }
        $stmt->close();
        $conn->close();
        return $notice;
    }
    
    function readstudiotoselect($selected){
        $notice = "<p>Stuudiot ei leitud</p>";
        $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT production_company_id, company_name FROM production_company");
        echo $conn->error;
        $stmt->bind_result($idfromdb, $companyfromdb);
        $stmt->execute();
        $studios = "";
        while($stmt->fetch()){
            $studios .= '<option value="' .$idfromdb .'"';
            if(intval($idfromdb) == $selected){
                $studios .=" selected";
            }
            $studios .= ">" .$companyfromdb ."</option> \n";
        }
        if(!empty($studios)){
            $notice = '<select name="filmstudiosinput">' ."\n";
            $notice .= '<option value="" selected disabled>Vali stuudio</option>' ."\n";
            $notice .= $studios;
            $notice .= "</select> \n";
        }
        $stmt->close();
        $conn->close();
        return $notice;
    }


    function storenewgenrerelation($selectedfilm, $selectedgenre){
        $notice = "";
        $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT movie_genre_id FROM movie_genre WHERE movie_id = ? AND genre_id = ?");
        echo $conn->error;
        $stmt->bind_param("ii", $selectedfilm, $selectedgenre);
        $stmt->bind_result($idfromdb);
        $stmt->execute();
        if($stmt->fetch()){
            $notice = "Selline seos on juba olemas!";
        } else {
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO movie_genre (movie_id, genre_id) VALUES(?,?)");
            echo $conn->error;
            $stmt->bind_param("ii", $selectedfilm, $selectedgenre);
            if($stmt->execute()){
                $notice = "Uus seos edukalt salvestatud!";
            } else {
                $notice = "Seose salvestamisel tekkis tehniline tõrge: " .$stmt->error;
            }
        }
        
        $stmt->close();
        $conn->close();
        return $notice;
    }

    function storenewstudiorelation($selectedfilm, $selectedstudio){
        $notice = "";
        $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("SELECT movie_by_production_company_id FROM movie_by_production_company WHERE movie_movie_id = ? AND production_company_id = ?");
        echo $conn->error;
        $stmt->bind_param("ii", $selectedfilm, $selectedstudio);
        $stmt->bind_result($idfromdb);
        $stmt->execute();
        if($stmt->fetch()){
            $notice = "Selline seos on juba olemas!";
        } else {
            $stmt->close();
            $stmt = $conn->prepare("INSERT INTO movie_by_production_company (movie_movie_id, production_company_id) VALUES(?,?)");
            echo $conn->error;
            $stmt->bind_param("ii", $selectedfilm, $selectedstudio);
            if($stmt->execute()){
                $notice = "Uus seos edukalt salvestatud!";
            } else {
                $notice = "Seose salvestamisel tekkis tehniline tõrge: " .$stmt->error;
            }
        }
        
        $stmt->close();
        $conn->close();
        return $notice;
    }

    function oldreadpersoninmovie(){
        $notice = "";
        $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $stmt=$conn->prepare("SELECT first_name, last_name, role, title FROM person JOIN person_in_movie ON person.person_id = person_in_movie.person_id JOIN movie ON movie.movie_id = person_in_movie.movie_id");
        echo $conn->error;
        $stmt->bind_result($firstnamefromdb, $lastnamefromdb, $rolefromdb, $titlefromdb);
        $stmt->execute();
        while($stmt->fetch()){
            $notice .= "<p>" .$firstnamefromdb ." " .$lastnamefromdb;
            if(!empty($rolefromdb)){
                $notice .= " tegelane " .$rolefromdb;
            }
            $notice .= ' filmis "' .$titlefromdb .'"' ."\n";
        }
        
        $stmt->close();
        $conn->close();
        return $notice;
    }

    function readpersoninmovie($sortby, $sortorder){
        $notice = "<p>Kahjuks ei leidnud filmitegelasi.</p>";
        $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
        $sqlphrase = "SELECT first_name, last_name, role, title FROM person JOIN person_in_movie ON person.person_id = person_in_movie.person_id JOIN movie ON movie.movie_id = person_in_movie.movie_id";
        if($sortby == 0){
            $stmt = $conn->prepare($sqlphrase);
        }
        if($sortby == 4){
            if($sortorder == 1){
                $stmt = $conn->prepare($sqlphrase ." ORDER BY title");
            } else {
                $stmt = $conn->prepare($sqlphrase ." ORDER BY title DESC");
            }
        }
        
        echo $conn->error;
        $stmt->bind_result($firstnamefromdb, $lastnamefromdb, $rolefromdb, $titlefromdb);
        $stmt->execute();
        $lines = "";
        while($stmt->fetch()){
            $lines .= "<tr> \n";
            $lines .= "\t <td>" .$firstnamefromdb ." " .$lastnamefromdb ."</td>";
            $lines .= "\t <td>" .$rolefromdb ."</td>";
            $lines .= "\t <td>" .$titlefromdb ."</td> \n";
            $lines .= "</tr> \n";
        }
        if(!empty($lines)){
            $notice = "<table> \n";
            $notice .= "<tr> \n";
            $notice .= "<th>Isik</th><th>Roll</th>";
            $notice .= '<th>Film &nbsp; <a href="?sortby=4&sortorder=1">&uarr;</a> &nbsp; <a href="?sortby=4&sortorder=2">&darr;</a></th>' ."\n";
            $notice .= "</tr> \n";
            $notice .= $lines;
            $notice .= "</table> \n";
        }
        $stmt->close();
        $conn->close();
        return $notice;
    }
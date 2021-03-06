<?php

	$database = "if20_karljanar_ki_1";
	
	
	function addperson($firstname, $lastname, $birthdate) {
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT first_name FROM person WHERE (first_name = ? AND last_name = ?)");
		echo $conn->error;
		$stmt->bind_param("ss", $firstname, $lastname);
		$stmt->bind_result($firstnamefromdb);
		if($stmt->execute()) {
			if($stmt->fetch()) {
				$notice = "See nimi on juba andmebaasis!";
			} else {
				$stmt->close();
				$stmt = $conn->prepare("INSERT INTO person (first_name, last_name, birth_date) VALUES (?, ?, ?)");
				echo $conn->error;
				$stmt->bind_param("sss", $firstname, $lastname, $birthdate);
				if($stmt->execute()) {
					$notice = "Isiku info salvestatud!";
				} else {
					$notice = $stmt->error;
				}
			}
		} else {
			$notice = $stmt->error;
		}
		$stmt->close();
		$conn->close();
		
		return $notice;
	}
	
	function addmovie($moviename, $movieyear, $movieduration, $description) {
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT title FROM movie WHERE title = ?");
		echo $conn->error;
		$stmt->bind_param("s", $moviename);
		$stmt->bind_result($moviefromdb);
		if($stmt->execute()) {
			if($stmt->fetch()) {
				$notice = "See film on juba andmebaasis!";
			} else {
				$stmt->close();
				$stmt = $conn->prepare("INSERT INTO movie (title, production_year, duration, description) VALUES (?, ?, ?, ?)");
				echo $conn->error;
				$stmt->bind_param("siis", $moviename, $movieyear, $movieduration, $description);
				if($stmt->execute()) {
					$notice = "Filmi info salvestatud!";
				} else {
					$notice = $stmt->error;
				}
			}
		} else {
			$notice = $stmt->error;
		}
		$stmt->close();
		$conn->close();
		
		return $notice;
	}
	
	function addposition($position, $positiondescription) {
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT position_name FROM position WHERE position_name = ?");
		echo $conn->error;
		$stmt->bind_param("s", $position);
		$stmt->bind_result($positionfromdb);
		if($stmt->execute()) {
			if($stmt->fetch()) {
				$notice = "See positsioon on juba andmebaasis!";
			} else {
				$stmt->close();
				$stmt = $conn->prepare("INSERT INTO position (position_name, description) VALUES (?, ?)");
				echo $conn->error;
				$stmt->bind_param("ss", $position, $positiondescription);
				if($stmt->execute()) {
					$notice = "See positsioon on salvestatud!";
				} else {
					$notice = $stmt->error;
				}
			}
		} else {
			$notice = $stmt->error;
		}
		$stmt->close();
		$conn->close();
		
		return $notice;
	}
	
	function addgenre($genre, $genredescription) {
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT genre_name FROM genre WHERE genre_name = ?");
		echo $conn->error;
		$stmt->bind_param("s", $genre);
		$stmt->bind_result($genrefromdb);
		if($stmt->execute()) {
			if($stmt->fetch()) {
				$notice = "See žanr on juba andmebaasis!";
			} else {
				$stmt->close();
				$stmt = $conn->prepare("INSERT INTO genre (genre_name, description) VALUES (?, ?)");
				echo $conn->error;
				$stmt->bind_param("ss", $genre, $genredescription);
				if($stmt->execute()) {
					$notice = " See žanr on salvestatud!";
				} else {
					$notice = $stmt->error;
				}
			}
		} else {
			$notice = $stmt->error;
		}
		$stmt->close();
		$conn->close();
		
		return $notice;
	}
	
	function addcompany($companyname, $companyaddress) {
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT company_name FROM production_company WHERE company_name = ?");
		echo $conn->error;
		$stmt->bind_param("s", $companyname);
		$stmt->bind_result($companyfromdb);
		if($stmt->execute()) {
			if($stmt->fetch()) {
				$notice = "See stuudio on juba andmebaasis!";
			} else {
				$stmt->close();
				$stmt = $conn->prepare("INSERT INTO production_company (company_name, company_address) VALUES (?, ?)");
				echo $conn->error;
				$stmt->bind_param("ss", $companyname, $companyaddress);
				if($stmt->execute()) {
					$notice = "See stuudio on salvestatud!";
				} else {
					$notice = $stmt->error;
				}
			}
		} else {
			$notice = $stmt->error;
		}
		$stmt->close();
		$conn->close();
		
		return $notice;
	}
	
	function addquote($quote_text) {
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT quote_text FROM quote WHERE quote_text = ?");
		echo $conn->error;
		$stmt->bind_param("s", $quote_text);
		$stmt->bind_result($quotetextfromdb);
		if($stmt->execute()) {
			if($stmt->fetch()) {
				$notice = "See quote on juba andmebaasis!";
			} else {
				$stmt->close();
				$stmt = $conn->prepare("INSERT INTO quote (quote_text, person_in_movie_id) VALUES (?, NULL)");
				echo $conn->error;
				$stmt->bind_param("s", $quote_text);
				if($stmt->execute()) {
					$notice = "See quote on salvestatud!";
				} else {
					$notice = $stmt->error;
				}
			}
		} else {
			$notice = $stmt->error;
		}
		$stmt->close();
		$conn->close();
		
		return $notice;
	}
?>
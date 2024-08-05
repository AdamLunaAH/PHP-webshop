<?php

	// links to the database function file
	require "config.php";

	// removes php errors from showing up on the website, commenting it out can be good during development for easier error checking
	// error_reporting(0);


/* server connection and error log*/
	function connectPDO() {
		try {
			$conn = new PDO("mysql:host=" . DBSERVER . ";dbname=" . DBNAME, DBUSERNAME, DBPASSWORD);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// set the character set to UTF-8
			$conn->exec("SET NAMES utf8mb4");
			return $conn;
			} catch (PDOException $e) {
			$error = $e->getMessage();
			$error_date = date("F j, Y, g:i a");
			$message = "{$error} | {$error_date} \r\n";
			file_put_contents("db-log.txt", $message, FILE_APPEND);
			return false;
			}
	}

	/* registration function */
	function registerUser($fornamn, $efternamn, $epost, $password, $confirm_password, $mobilnr, $gatuadress, $postnr, $ort){
    $pdo = connectPDO();
    $args = func_get_args();
    $args = array_map(function ($value) {
        return trim($value);
    }, $args);
    foreach ($args as $value) {
        if(empty($value)){
            return "Alla fälten måste fyllas i";
        }
    }
    foreach ($args as $value) {
        if (preg_match("/([[\/[^\'<|£$%^&*()}{:\'#~?><>,;\|\-=\-_+\-¬\`\]';>])/", $value)) {
					return "Specialtecken får inte användas";
				}
		}
		if (!filter_var($epost, FILTER_VALIDATE_EMAIL)) {
				return "E-post är inte giltig";
		}
		$stmt = $pdo->prepare("SELECT epost FROM medlem WHERE epost = ?");
		$stmt->execute([$epost]);
		$data = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($data != false){
				return "E-post finns redan, använd en annan e-postadress";
		}
		if (strlen($fornamn) > 40){
				return "Förnamnet är för långt";
		}
		if (strlen($efternamn) > 100) {
				return "Efternamnet är för långt";
		}
		if (strlen($password) > 255) {
				return "Lösenordet är för långt";
		}
		if (strlen($password) < 10) {
				return "Lösenordet är för kort, lösenordet måste bestå av minst 10 tecken";
		}
		if ($password != $confirm_password) {
				return "Lösenorden är inte lika";
		}
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		$stmt = $pdo->prepare("INSERT INTO medlem(fornamn, efternamn, epost,  password, mobilnr, gatuadress, postnr, ort) VALUES(?,?,?,?,?,?,?,?)");
		$stmt->execute([$fornamn, $efternamn, $epost, $hashed_password, $mobilnr, $gatuadress, $postnr, $ort]);
		if ($stmt->rowCount() != 1) {
				return "Ett fel uppstod. Var god försök igen";
		} else {
				return "success";
		}}

			function loginUser($Epost, $Password) {

						$pdo = connectPDO();

						$Epost = htmlspecialchars($Epost);
						$Password = htmlspecialchars($Password);
						$Epost = trim($Epost);
						$Password = trim($Password);

						if ($Epost == "" || $Password == "") {
								return "Båda fälten är obligatoriska";
						}

						$stmt = $pdo->prepare("SELECT Epost, MemberID, password FROM medlem WHERE Epost = ?");
						$stmt->bindParam(1, $Epost);
						$stmt->execute();
						$data = $stmt->fetch(PDO::FETCH_ASSOC);

						if ($data == false) {
								return "Fel e-post eller lösenord";
						}

						if (password_verify($Password, $data["password"])) {
								session_start();
								session_regenerate_id(true);
								$_SESSION["user"] = htmlspecialchars($Epost);
								$_SESSION["userid"] = htmlspecialchars($data["MemberID"]);
								header("location: /wpmywebsite/ebutik/medlemskonto/");
								exit();
						} else {
								return "Fel E-post eller lösenord";
						}
				}




	// logout function
	function logoutUser() {
		session_start();
		session_unset();
		session_destroy();
		header("Refresh:0");
		exit();
		}



	//Reset password function dont work fully, a new password is given but not sent to the member
	function passwordReset($epost) {

        $db = connectPDO();
        $email = trim($epost);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "E-posten är inte giltig";
        }
        $stmt = $db->prepare("SELECT epost FROM medlem WHERE epost = ?");
        $stmt->execute([$email]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data == NULL) {
            return "E-posten finns inte som medlem";
        }
        $str = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz";
        $password_length = 12;
        $new_pass = substr(str_shuffle($str), 0, $password_length);
        $hashed_password = password_hash($new_pass, PASSWORD_DEFAULT);
        $stmt = $db->prepare("UPDATE medlem SET password = ? WHERE epost = ?");
        $stmt->execute([$hashed_password, $epost]);
        if ($stmt->rowCount() != 1) {
            return "There was a connection error, please try again.";
        }
        $to = $email;
        $subject = "Password recovery";
        $body = "Du kan logga in med ditt nya lösenord" . "\r\n";
        $body .= $new_pass;
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: Admin \r\n";
        $send = mail($to, $subject, $body, $headers);
        if (!$send) {
            return "Email not send. Please try again";
        } else {
            return "Lösenordet har ändrats";
        }
    }


	// Delete account function
	function deleteAccount() {
		$pdo = connectPDO();
		$sql = "DELETE FROM medlem WHERE epost = :email";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':email', $_SESSION['user']);
		$stmt->execute();
		if ($stmt->rowCount() != 1) {
		return "An error occurred. Please try again";
		} else {
		session_destroy();
		header("location: /wpmywebsite/ebutik/");
		exit();}}


?>
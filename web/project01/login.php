<?php

session_start();


if ($_GET['logout'] == 1 AND $_SESSION['id']){

	session_destroy();
	debug_to_console("Logout Action");
	$message = "You have been logged out. Have a great day!";
}

include("connection.php");

if ($_POST['submit'] == "Sign Up") {

	debug_to_console('You clicked sign up');

	if (!$_POST['email']) 
		$error .= "<br>Please enter your loginEmail";
	else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		$error .= "<br>Invalid email address";

	if (!($_POST['password']))
		$error .= "<br>Please enter your password";
	else {

		if (strlen($_POST['password']) < 8)
			$error .= "<br>Please enter a password with at least 8 characters";

		if (!preg_match('`[A-Z]`', $_POST['password']))
			$error .= "<br>Please include at least one capital letter in password";
		if ($_POST['password2'] AND $_POST['password'] != $_POST['password2'])
			$error .="<br>Passwords do not match";

	}

	if ($error)
		$error = "<strong>There were errors in your signup details:</strong> ".$error;
	else {

		debug_to_console("Checking the DB");

		//$query = "SELECT * FROM users WHERE user_email = '" . pg_escape_string($db, $_POST['email']) . "'";
		$query = $db->prepare('SELECT * FROM users WHERE user_email = :email');
		$query->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
		$query->execute();
		$rows = $query->fetchAll(PDO::FETCH_ASSOC);


		if ($rows)
			$error = "There is already an account with that email address. Do you want to log in?";
		else {

			debug_to_console("Creating new account");

			$today = date("Y-m-d");
			$query1 = $db->prepare('INSERT INTO diaries (diary_last_modified) VALUES (:today)');
			$query1->bindValue(':today', $today, PDO::PARAM_STR);
			$query1->execute();

			$diary_id = $db->lastInsertId();


			//$query = "INSERT INTO `users` (`user_email`, `user_password`) VALUES ('".pg_escape_string($db, $_POST['email'])."', '".md5(md5($_POST['email']).$_POST['password'])."')";

			$passhash = md5(md5($_POST['email']).$_POST['password']);
			$query = $db->prepare('INSERT INTO users (user_email, user_password, user_diary) VALUES (:email, :passhash, :diary)');
			$query->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
			$query->bindValue(':passhash', $passhash, PDO::PARAM_STR);
			$query->bindValue(':diary', $diary_id, PDO::PARAM_INT);
			$query->execute();
			//$rows = $query->fetchAll(PDO::FETCH_ASSOC);
			$userID = $db->lastInsertId();


			echo "You've been signed up!";

			

			$_SESSION['id'] = $userID;
			debug_to_console($userID);


			// header('Location: mainpage.php');
		}

	}

}

if ($_POST['submit'] == "Log In") {

	debug_to_console("Trying to log in");

	$query = "SELECT * FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['loginEmail'])."' AND password = '".md5(md5($_POST['loginEmail']).$_POST['loginPassword'])."' LIMIT 1";

	$result = mysqli_query($link, $query);

	$row = mysqli_fetch_array($result);

	if ($row) {

		$_SESSION['id'] = $row['id'];

		// header('Location: mainpage.php');
	} else {

		$error = "<strong>We could not find a user with that email and password. Please try again.</strong>";
	}

}




?>
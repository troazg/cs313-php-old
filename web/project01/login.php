<?php

session_start();

if ($_GET['logout'] == 1 AND $_SESSION['id']){

	session_destroy();
	$message = "You have been logged out. Have a great day!";
}

include("connection.php");

if ($_POST['submit'] == "Sign Up") {

	if (!$_POST['email']) 
		$error .= "<br>Please enter you loginEmail";
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

		$query = "SELECT * FROM users WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";

		$result = mysqli_query($link, $query);

		$results = mysqli_num_rows($result);

		if ($results)
			$error = "There is already an account with that email address. Do you want to log in?";
		else {

			$query = "INSERT INTO `users` (`email`, `password`) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."', '".md5(md5($_POST['email']).$_POST['password'])."')";

			mysqli_query($link, $query);

			echo "You've been signed up!";

			$_SESSION['id'] = mysqli_insert_id($link);

			header('Location: mainpage.php');
		}

	}

}

if ($_POST['submit'] == "Log In") {

	$query = "SELECT * FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['loginEmail'])."' AND password = '".md5(md5($_POST['loginEmail']).$_POST['loginPassword'])."' LIMIT 1";

	$result = mysqli_query($link, $query);

	$row = mysqli_fetch_array($result);

	if ($row) {

		$_SESSION['id'] = $row['id'];

		header('Location: mainpage.php');
	} else {

		$error = "<strong>We could not find a user with that email and password. Please try again.</strong>";
	}

}




?>
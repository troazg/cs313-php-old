<?php
session_start();

reset($_POST);
$key = key($_POST);

$_SESSION[$key] = $_POST[$key];

// if (isset($_POST['name1'])) {
// 	$_SESSION['name1'] = $_POST['name1'];
// 	$_SESSION['desc1'] = $_POST['desc1'];
// }

// if (isset($_POST['name2'])) {
// 	$_SESSION['name2'] = $_POST['name2'];
// 	$_SESSION['desc2'] = $_POST['desc2'];
// }

// if (isset($_POST['name3'])) {
// 	$_SESSION['name3'] = $_POST['name3'];
// 	$_SESSION['desc3'] = $_POST['desc3'];
// }

// if (isset($_POST['name4'])) {
// 	$_SESSION['name4'] = $_POST['name4'];
// 	$_SESSION['desc4'] = $_POST['desc4'];
// }

// if (isset($_POST['name5'])) {
// 	$_SESSION['name5'] = $_POST['name5'];
// 	$_SESSION['desc5'] = $_POST['desc5'];
// }

?>
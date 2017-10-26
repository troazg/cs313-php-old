<?php

session_start();

include('connection.php');

$query = $db->prepare('UPDATE diaries AS d SET diary_text = :diary FROM users AS u WHERE u.user_id = :id AND d.diary_id = u.user_diary');
$query->bindValue(':diary', $_POST['diary'], PDO::PARAM_STR);
$query->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
$query->execute();


?>

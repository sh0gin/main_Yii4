<?php

require_once "main.php";

$sql =  $mysql->select("SELECT id, role FROM user WHERE token='{$_POST['token']}'")[0];
$_POST['autor_id'] = $sql['id'];
unset($_POST['token']);

printd($_POST);
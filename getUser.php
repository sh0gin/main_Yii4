<?php

require_once __DIR__ . '/mainPhp.php';

if ($_POST["token"]) {
    $user_data = $mysql->select("SELECT * FROM USER where token= '{$_POST["token"]}'");
    $user->load($user_data[0]);

    echo json_encode(get_object_vars($user));
}

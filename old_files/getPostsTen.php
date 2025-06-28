<?php

require_once __DIR__ . '/mainPhp.php';

$post = new Post($user, $request, $response);
$result = [];
if ($_POST['token']) {
    $token = $_POST['token'];
    $mas = $mysql->select("SELECT id, role FROM user where token='$token'")[0];   
    $id = $mas["id"];   
    $role = $mas["role"];   
    foreach ($post->get_post_ten() as $value) {
        $result[] = [$value, $id, $role];
    }
    echo json_encode($result);
} else {
    foreach ($post->get_post_ten() as $value) {
        $result[] = [$value];
    }

    echo json_encode($result);
}



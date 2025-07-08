<?php
require_once __DIR__ . '/mainPhp.php';



$post = new Post($user, $request, $response);
$result = [];


if ($_POST['token']) {
    $token = $_POST['token'];
    $mas = $mysql->select("SELECT id, role FROM user where token='$token'")[0];
    $id = $mas["id"];
    $role = $mas["role"];


    foreach ($post->getPosts(limit: (int) $_POST['limit'], offset: (int) $_POST['number_page'], ten_post: $_POST['ten_post']) as $value) {
        $result[] = [$value, $id, $role];
    }
    echo json_encode($result);
} else {
    foreach ($post->getPosts(limit: 5, offset: (int) $_POST['number_page'], ten_post: $_POST['ten_post']) as $value) {
        $result[] = [$value];
    }

    echo json_encode($result);
}

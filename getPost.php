<?php

require_once __DIR__ . '/mainPhp.php';

$post = new Post($user, $request, $response);
$post->findOne($_POST["id"]);
$post->user->identity($post->autor_id);

if ($_POST['token']) {
    $token = $_POST['token'];
    $mas = $mysql->select("SELECT id, role FROM user where token='$token'")[0];   
    $id = $mas["id"];
    $role = $mas["role"];  
     
    
    echo json_encode([$post, $id, $role]);
} else {
    echo json_encode([$post, 0, 0]);
}




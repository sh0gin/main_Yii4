<?php
require_once "main.php";

// printd($_POST);
// printd($_GET);
// die;

// if (!$mysql->repeat_check("post", "id", $request->get("id"))) {
//     $response->redirect("index.php");
// }



$sql =  $mysql->select("SELECT id, role FROM user WHERE token='{$_POST['token']}'")[0];
$_POST['autor_id'] = $sql['id'];

unset($_POST['token']);


if ($_SERVER["REQUEST_METHOD"] == "POST" && $sql) {

    // if (!$user->isAdmin && !$user->isGuest) {
    $comment->load_comment($_POST);
    $comment->post->findOne($_POST['post_id']);
    $comment->user->identity($_POST['autor_id']);

    // if ($comment->validate()) {

    // } else {
    //     if ($comment->save()) {
    //         $response->redirect("post.php", ["id" => $request->get("id")]);
    //     }
    // }

    if (!$comment->validate()) {
        if (array_key_exists('comment_id', $_POST)) {
            if ($comment->save($_POST['comment_id'])) {
            }
        } else {
            if ($comment->save()) {
            }
        }

        // if ($request->get("comment_id")) {
        //     if ($comment->save($request->get("comment_id"))) {
        //     }
        // } else {
        //     if ($comment->save()) {
        //     }
        // }
    }
    // }
}

// if ($request->get("id")) {
//     $login = $mysql->select("SELECT login FROM USER WHERE id = '{$mysql->select("SELECT autor_id FROM POST WHERE id = '{$request->get('id')}'")[0]['autor_id']}'")[0]['login'];
// }
// if ($request->get("token")) {
//     $mylogin = $mysql->select("SELECT login from USER where token = '{$request->get("token")}'")[0]['login'];
// } else {
//     $mylogin = false;
// }

// if ($request->get("id")) {
//     $post->findOne($request->get("id"));
// } else {
//     $response->redirect("index.php");
// }

// $mas = $mysql->select("SELECT * FROM post WHERE id = '{$request->get("id")}'");
// var_dump($post); die;
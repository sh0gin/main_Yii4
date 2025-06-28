<?php
require_once __DIR__ . "/main.php";
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['token'] !== "null") {
    if (isset($_FILES["image"]) && empty($_FILES['image']['error'])) {
        $fileTemp = $_FILES['image']['tmp_name'];
        $fileName = "images/" . $_FILES['image']['name'];
        if (move_uploaded_file($fileTemp, $fileName)) {
            $post->url_image = $fileName;
        }
    }

    $post->load($_POST);
    if (!$post->validate()) {
        if ($post->save($_POST['id_post'])) {
            if ($_POST['id_post'] !== "null") {
                $id = $_POST["id_post"];
            } else {
                $id = $post->user->mysql->insert_id;
            }
            $post->save_image($id);
            $post->findOne($id);
            $post->giveInfo();
        }
    }
}

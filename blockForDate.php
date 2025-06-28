<?php

require_once "main.php";

if ($_POST['id_user'] && $_POST['date']) {
    $block->block($_POST['date'], $_POST['id_user']);
} else {
    echo json_encode(['status' => false, "message" => "Пустое значение"]);
}


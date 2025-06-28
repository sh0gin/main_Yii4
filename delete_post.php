<?php

require_once "main.php";

if ($post->delete_post($_POST["id_post"])) {
    echo json_encode([
        "status" => true,
    ]);
} else {
    echo json_encode([
        "status" => false,
    ]);
};


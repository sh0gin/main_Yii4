<?php

class Post
{
    public $id;
    public $date;
    public $autor_id;
    public $comments;

    public $title;
    public $preview;
    public $content;

    public $url_image;

    public $valid_title;
    public $valid_preview;
    public $valid_content;

    public $user;
    public $request;
    public $response;

    public function __construct($user, $request, $response)
    {
        $this->user = $user;
        $this->request = $request;
        $this->response = $response;
        if ($this->request->get("id")) {
            $this->findOne($this->request->get("id"));
        }
    }

    public function validate(): bool
    {
        $valid = Asists::validateDate($this);

        if ($valid) {
            echo json_encode([
            'status' => $valid,
            'title' => $this->title,
            'content' => $this->content,
            'preview' => $this->preview,
            'valid_title' => $this->valid_title,
            'valid_content' => $this->valid_content,
            'valid_preview' => $this->valid_preview,
        ]);
        }

        return $valid;
    }

    public function load($array): void
    {
        if (array_key_exists("token", $array)) { // проверка на токен авторизации
            $token = $array['token'];
            $id = $this->user->mysql->select("SELECT id FROM user where token='$token'")[0]['id']; // достаём id из бд
            if ($id) {
                unset($array['token']);
                $array["autor_id"] = $id;
            }
        }
        Asists::loadData($this, $array);
    }

    public function findOne(?int $id = null): bool
    {
        $result = false;
        if ($id) {
            $mas = $this->user->mysql->select("select * from post where id = '$id'");
            $this->load($mas[0]);

            $this->date = Asists::format_date(new Datetime($this->date));
            $this->comments = $this->user->mysql->select("SELECT COUNT(*) FROM `comment` WHERE post_id = '$id'")[0]['COUNT(*)'];
            $result = true;
            $this->url_image = $this->user->mysql->select("SELECT image FROM image where post_id ='$id' ORDER BY id DESC limit 1");
            if ($this->url_image) {
                $this->url_image = $this->url_image[0]["image"];
            }
        }

        return $result;
    }

    public function giveInfo() {
        echo json_encode([
            'status' => false,
            'title' => $this->title,
            'content' => $this->content,
            'preview' => $this->preview,
            'valid_title' => $this->valid_title,
            'valid_content' => $this->valid_content,
            'valid_preview' => $this->valid_preview,
            'id' => $this->id,
        ]);
    }

    public function save($id_post): bool
    {
        $content = Asists::replace_rn($this->content);
        if ($id_post !== "null") {
            $sqlRequest = $this->user->mysql->query("UPDATE post set content = '{$content}', title = '{$this->title}', preview = '{$this->preview}' Where id = '$id_post'");
        } else {
            $sqlRequest = $this->user->mysql->query("INSERT into post (autor_id, content, title, preview) VALUES ('{$this->autor_id}', '$content', '{$this->title}', '{$this->preview}')");
        }

        if ($sqlRequest) {
            return true;
        }

        return false;
    }

    public function save_image($id)
    {
        if ($this->url_image) {

            if ($this->user->mysql->query("INSERT into image (post_id, image) VALUES ('$id', '{$this->url_image}')")) {

                return true;
            };
        }
        return false;
    }

    public function get_date(): bool | string
    {
        return Asists::format_date($this->date);
    }

    public function getPosts($limit = false, $offset = 0, $ten_post=false): array // выдает массив с постами. Если есль лимит то он ограничен, если нет, все посты выдаёт.
    {
        
        if ($ten_post === "false") {
            if ($offset !== 0) {
                $offset = ($offset - 1) * 5;
            }
        }

        $result = [];
        $request = $this->user->mysql->select("SELECT * FROM POST ORDER BY date DESC Limit $limit OFFSET $offset");
        foreach ($request as $value) {
            $exam_user = new user($this->request, $this->user->mysql);
            $exam_user->identity($value["autor_id"]);
            $exam_post = new static($exam_user, $this->request, $this->response);
            $exam_post->findOne($value['id']);
            $exam_post->load($value);
            $result[] = $exam_post;
        }
        return $result;
    }


    public function get_post_ten(): array
    {
        return $this->getPosts(10, ten_post:true);
    }

    public function delete_post($id = null): bool
    {
        if ($id) {
            if ($this->user->mysql->query("DELETE FROM POST WHERE id = '{$id}'")) {
                return true;
            }
        }
        return false;
    }
}

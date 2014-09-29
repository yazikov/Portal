<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 9/14/14
 * Time: 2:48 PM
 */

class DAO {

    private $connection;

    function __construct()
    {
        $ini_array = parse_ini_file("connection.ini");
        $this->connection = new mysqli($ini_array['host'], $ini_array['user'],$ini_array['password'],$ini_array['dbname']);
        if ($this->connection->connect_errno) {
            die('Ошибка соединения'.$this->connection->error);
        }
    }

    /**
     * Получение количества статей данной категории
     * @param $id_category int идентификатор категории
     * @return int количество статей
     */
    public function getTextCount($id_category) {
        $count = 0;
        $connection = $this->connection;
        $res = $connection->query('select count(*) c from text where id_category = '.$id_category);
        if($row = $res->fetch_assoc()) {
            $count = $row['c'];
        }
        $res->free();
        return $count;
    }

    /**
     * Получает список статей для данной категории
     * @param $id_category int идентификатор категории
     * @param $page int номер страницы
     * @return array список статей
     */
    public function  getTextPage($id_category, $page)
    {
        $text_list = array();
        $start = ($page - 1) * 10;
        $category = $this->getCategoryById($id_category);
        $connection = $this->connection;
        $res = $connection->query("select * from text where id_category = ".$id_category." limit ".$start.", 10 ");
        while($row = $res->fetch_assoc()) {
            $user = $this->getUserById($row['id_user']);
            $text = new Text($row['id'], $category, $user);
            $text->setTitle($row['title']);
            $text->setShortText($row['short_text']);
            $text->setImages($this->getImagesByTextId($row['id']));
            $text->setLikes($this->getLikesByTextId($row['id']));
            array_push($text_list, $text);
        }
        $res->free();
        return $text_list;
    }

    public function getRandomText($id_category, $id_last_text) {
        $text = null;
        $count = $this->getTextCount($id_category);
        $id = null;
        $start = rand(0, $count - 1);
        while($start == $id_last_text - 1) {
            $start = rand(0, $count - 1);
        }
        $end = $start + 1;
        $sql = "select * from text where id_category = ".$id_category." limit ".$start.", ".$end;
        $category = $this->getCategoryById($id_category);
        $connection = $this->connection;
        $res = $connection->query($sql);
        if($row = $res->fetch_assoc()) {
            $id = $row['id_user'];
            if ($id_last_text || $id != $id_last_text) {
                $user = $this->getUserById($row['id_user']);
                $text = new Text($id, $category, $user);
                $text->setTitle($row['title']);
                $text->setShortText($row['short_text']);
                $text->setText($row['text']);
                $text->setLikes($this->getLikesByTextId($row['id']));
            }
        }
        if ($res) {
            $res->free();
        }
        return $text;
    }

    /**
     * Получаем статью по идентификатору
     * @param $id int идентификатор статьи
     * @return null|Text статья
     */
    public function getTextById($id) {
        $text = null;
        $connection = $this->connection;
        $res = $connection->query("select * from text where id = ".$id);
        if($row = $res->fetch_assoc()) {
            $user = $this->getUserById($row['id_user']);
            $category = $this->getCategoryById($row['id_category']);
            $text = new Text($row['id'], $category, $user);
            $text->setMetaDescription($row['meta_description']);
            $text->setMetaTag($row["meta_tag"]);
            $text->setText($row['text']);
            $text->setComments($this->getCommentsByTextId($id));
            $text->setImages($this->getImagesByTextId($id));
            $text->setLikes($this->getLikesByTextId($id));
            array_push($text_list, $text);
        }
        $res->free();
        return $text;
    }

    /**
     * Получает список комментариев статьи
     * @param $text_id int идентификатор статьи
     * @return array список комментариев
     */
    public function getCommentsByTextId($text_id) {
        $comments = array();
        $connection = $this->connection;
        $res = $connection->query("select * from comment  where id_text = ".$text_id);
        while($row = $res->fetch_assoc()) {
            $user = $this->getUserById($row['id_user']);
            $comment = new Comment($row['c.id'], $row['c.text'], $user);
            array_push($comments, $comment);
        }
        $res->free();
        return $comments;
    }

    /**
     * Получает список изображений статьи
     * @param $text_id int идентификатор статьи
     * @return array список изображений
     */
    public function getImagesByTextId($text_id) {
        $images = array();
        $connection = $this->connection;
        $res = $connection->query("select i.id, i.url from galary tg join image i on i.id = tg.id_image  where tg.id_text = ".$text_id);
        while($row = $res->fetch_assoc()) {
            $image = new Image($row['id'], $row['url']);
            array_push($images, $image);
        }
        $res->free();
        return $images;
    }

    /**
     * Получает список лайков статьи
     * @param $text_id int идентификатор статьи
     * @return array список лайков
     */
    public function getLikesByTextId($text_id) {
        $likes = array();
        $connection = $this->connection;
        $res = $connection->query("select * from text_like where id_text = ".$text_id);
        while($row = $res->fetch_assoc()) {
            $user = $this->getUserById($row['id_user']);
            $like = new Like($row['id'], $user);
            array_push($likes, $like);
        }
        $res->free();
        return $likes;
    }

    /**
     * Получает роль пользователя по идентификатору
     * @param $id int идентификатор пользователя
     * @return null|Role роль пользователя
     */
    public function getRoleById($id) {
        $role = null;
        $connection = $this->connection;
        $res = $connection->query("select * from role where id = ".$id);
        if($row = $res->fetch_assoc()) {
            $role = new Role($row['id'], $row['name']);
        }
        $res->free();
        return $role;
    }

    /**
     * Получает изображение по идентификатору
     * @param $id int идентификатор изображения
     * @return Image|null изображение
     */
    public function getImageById($id) {
        $image = null;
        $connection = $this->connection;
        $res = $connection->query("select * from image where id = ".$id);
        if($row = $res->fetch_assoc()) {
            $image = new Image($row['id'], $row['url']);
        }
        $res->free();
        return $image;
    }

    /**
     * Получает категорию по идентификатору
     * @param $id int идентификатор категории
     * @return Category|null категория
     */
    public function getCategoryById($id) {
        $category = null;
        $connection = $this->connection;
        $res = $connection->query("select * from category where id = ".$id);
        if($row = $res->fetch_assoc()) {
            $category = new Category($row['id'], $row['name']);
        }
        $res->free();
        return $category;
    }

    /**
     * Получает пользователя по идентификатору
     * @param $id int идентификатор
     * @return null|User пользователь
     */
    public function getUserById($id) {
        $user = null;
        $connection = $this->connection;
        $res = $connection->query("select u.id, u.login, u.password, u.fio, u.work, u.email, u.sex, r.id rid, r.name rname, i.id iid, i.url iurl from user u join role r on u.id_role = r.id join image i on u.id_image = i.id where u.id = ".$id);
        if ($res) {
            if($row = $res->fetch_assoc()) {
                $image = new Image($row['iid'], $row['iurl']);
                $role = new Role($row['rid'], $row['iname']);
                $user = new User($row['id'], $row['about'], $row['birthday'], $row['email'], $row['fio'], $image , $row['login'], $row['password'], $row['sex'], $row['work'], $role);
            }
            $res->free();
        }
        return $user;
    }

    public function checkUser($login) {
        $result = false;
        $connection = $this->connection;
        $res = $connection->query("select count(*) c from user where login = '".$login."'");
        if ($res && $row = $res->fetch_assoc()) {
            $count = $row['c'];
            if ($count > 0) {
                $result = true;
            }
            $res->free();
        }
        return $result;
    }

    public function checkUserAndPassword($login, $password) {
        $user_id = null;

        return $user_id;
    }

    public function saveUser($user) {
        $connection = $this->connection;
        $stmt = $connection->prepare("insert into user(login, password, fio, birthday, sex, email, work, about) values(?,?,?,?,?,?,?,?)");
        $login = $user->getLogin();
        $password = $user->getPassword();
        $fio = $user->getFio();
        $birthday = $user->getBirthday();
        $sex = $user->getSex();
        $email = $user->getEmail();
        $work = $user->getWork();
        $about = $user->getAbout();
        $stmt->bind_param('ssssssss', $login, $password, $fio, $birthday, $sex, $email, $work, $about);
        $stmt->execute();
        return $connection->insert_id;
    }

    public function close() {
        $this->connection->close();
    }
}
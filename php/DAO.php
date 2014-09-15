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
        $ini_array = parse_ini_file("../connection.ini");
        $this->connection = new mysqli($ini_array['host'], $ini_array['user'],$ini_array['password'],$ini_array['dbname']);
    }

    /**
     * Получение количества статей данной категории
     * @param $id_category int идентификатор категории
     * @return int количество статей
     */
    public function getTextCount($id_category) {
        $count = 0;
        $connection = $this->connection;
        $res = $connection->query("select count(*) from text where id_category = {$$id_category} ");
        if($row = $res->fetch_assoc()) {
            $count = $row[0];
        }
        $res->free();
        $res->close();
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
        $res = $connection->query("select * from text where id_category = {$$id_category} limit {$start}, 10 ");
        while($row = $res->fetch_assoc()) {
            $user = $this->getUserById($row['id_user']);
            $text = new Text($row['id'], $category, $user);
            $text->setShortText($row['short_text']);
            $text->setImages($this->getImagesByTextId($row['id']));
            $text->setLikes($this->getLikesByTextId($row['id']));
            array_push($text_list, $text);
        }
        $res->free();
        $res->close();
        return $text_list;
    }

    /**
     * Получаем статью по идентификатору
     * @param $id int идентификатор статьи
     * @return null|Text статья
     */
    public function getTextById($id) {
        $text = null;
        $connection = $this->connection;
        $res = $connection->query("select * from text where id = {$$id}");
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
        $res->close();
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
        $res = $connection->query("select * from text_comment tc join comment c  on c.id = tc.id_comment  where tc.id_text = {$text_id} ");
        while($row = $res->fetch_assoc()) {
            $user = $this->getUserById($row['id_user']);
            $comment = new Comment($row['c.id'], $row['c.text'], $user);
            array_push($comments, $comment);
        }
        $res->free();
        $res->close();
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
        $res = $connection->query("select * from text_galary tg join image i  on i.id = tg.id_image  where tg.id_text = {$text_id} ");
        while($row = $res->fetch_assoc()) {
            $image = new Image($row['i.id'], $row['i.url']);
            array_push($images, $image);
        }
        $res->free();
        $res->close();
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
        $res = $connection->query("select * from text_like where id_text = {$text_id} ");
        while($row = $res->fetch_assoc()) {
            $user = $this->getUserById($row['id_user']);
            $like = new Like($row['id'], $user);
            array_push($likes, $like);
        }
        $res->free();
        $res->close();
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
        $res = $connection->query("select * from role where id = {$id}");
        if($row = $res->fetch_assoc()) {
            $role = new Role($row['id'], $row['name']);
        }
        $res->free();
        $res->close();
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
        $res = $connection->query("select * from image where id = {$id}");
        if($row = $res->fetch_assoc()) {
            $image = new Image($row['id'], $row['url']);
        }
        $res->free();
        $res->close();
        return $image;
    }

    /**
     * Получает пол по идентификатору
     * @param $id int идентификатор пола
     * @return null|Sex пол
     */
    public function getSexById($id) {
        $sex = null;
        $connection = $this->connection;
        $res = $connection->query("select * from sex where id = {$id}");
        if($row = $res->fetch_assoc()) {
            $sex = new Sex($row['id'], $row['name']);
        }
        $res->free();
        $res->close();
        return $sex;
    }

    /**
     * Получает категорию по идентификатору
     * @param $id int идентификатор категории
     * @return Category|null категория
     */
    public function getCategoryById($id) {
        $category = null;
        $connection = $this->connection;
        $res = $connection->query("select * from category where id = {$id}");
        if($row = $res->fetch_assoc()) {
            $category = new Category($row['id'], $row['name']);
        }
        $res->free();
        $res->close();
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
        $res = $connection->query("select * from user where id = {$id}");
        if($row = $res->fetch_assoc()) {
            //todo переделать получение под join
            $image = $this->getImageById($row['id_image']);
            $role = $this->getImageById($row['id_role']);
            $sex = $this->getImageById($row['id_sex']);
            $user = new User($row['id'], $row['about'], $row['birthday'], $row['email'], $row['fio'], $image , $row['login'], $row['password'], $sex, $row['work'], $role);
        }
        $res->free();
        $res->close();
        return $user;
    }
}
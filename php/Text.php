<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 9/14/14
 * Time: 3:09 PM
 */

class Text {
    private $id;
    private $short_text;
    private $text;
    private $user;
    private $meta_description;
    private $meta_tag;
    private $category;
    private $checked;
    private $images;
    private $comments;
    private $likes;

    function __construct($category, $id, $comments, $checked, $images, $likes, $meta_description, $short_text, $meta_tag, $text, $user)
    {
        $this->category = $category;
        $this->id = $id;
        $this->comments = $comments;
        $this->checked = $checked;
        $this->images = $images;
        $this->likes = $likes;
        $this->meta_description = $meta_description;
        $this->short_text = $short_text;
        $this->meta_tag = $meta_tag;
        $this->text = $text;
        $this->user = $user;
    }


} 
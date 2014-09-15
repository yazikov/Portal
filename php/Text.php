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
    private $images;
    private $comments;
    private $likes;

    function __construct($id, $category, $user)
    {
        $this->id = $id;
        $this->category = $category;
        $this->user = $user;
    }

    /**
     * @param mixed $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }

    /**
     * @return mixed
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param mixed $likes
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;
    }

    /**
     * @return mixed
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * @param mixed $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $meta_description
     */
    public function setMetaDescription($meta_description)
    {
        $this->meta_description = $meta_description;
    }

    /**
     * @return mixed
     */
    public function getMetaDescription()
    {
        return $this->meta_description;
    }

    /**
     * @param mixed $meta_tag
     */
    public function setMetaTag($meta_tag)
    {
        $this->meta_tag = $meta_tag;
    }

    /**
     * @return mixed
     */
    public function getMetaTag()
    {
        return $this->meta_tag;
    }

    /**
     * @param mixed $short_text
     */
    public function setShortText($short_text)
    {
        $this->short_text = $short_text;
    }

    /**
     * @return mixed
     */
    public function getShortText()
    {
        return $this->short_text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }




} 
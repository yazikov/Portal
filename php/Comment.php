<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 9/14/14
 * Time: 3:17 PM
 */

class Comment {
    private $id;
    private $text;
    private $user;

    function __construct($id, $text, $user)
    {
        $this->id = $id;
        $this->text = $text;
        $this->user = $user;
    }
} 
<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 9/14/14
 * Time: 3:26 PM
 */

class Image {
    private $id;
    private $url;

    function __construct($id, $url)
    {
        $this->id = $id;
        $this->url = $url;
    }


} 
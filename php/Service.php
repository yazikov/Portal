<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 9/14/14
 * Time: 3:27 PM
 */

class Service {
    private $id;
    private $name;

    function __construct($name, $id)
    {
        $this->name = $name;
        $this->id = $id;
    }
} 
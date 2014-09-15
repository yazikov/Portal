<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 9/14/14
 * Time: 3:18 PM
 */

class Sex {
    private $id;
    private $name;

    function __construct($id, $name)
    {
        $this->name = $name;
        $this->id = $id;
    }


} 
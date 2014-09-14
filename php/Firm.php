<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 9/14/14
 * Time: 3:15 PM
 */

class Firm {
    private $id;
    private $name;
    private $text;
    private $service;
    private $phone;
    private $site;
    private $address;
    private $map;

    function __construct($address, $id, $map, $name, $phone, $service, $site, $text)
    {
        $this->address = $address;
        $this->id = $id;
        $this->map = $map;
        $this->name = $name;
        $this->phone = $phone;
        $this->service = $service;
        $this->site = $site;
        $this->text = $text;
    }


} 
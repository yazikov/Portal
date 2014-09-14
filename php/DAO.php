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
        $this->connection = mysqli_connect($ini_array['host'], $ini_array['user'],$ini_array['password'],$ini_array['dbname']);
    }

    public function  getTextPage($id_category, $page)
    {
        $start = $page * 10;
        $res = mysqli_query($this->connection, "select * from text where id_category = {$$id_category} limit {$start},10 ");
    }
}
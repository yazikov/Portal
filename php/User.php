<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 9/14/14
 * Time: 3:06 PM
 */

class User {
    private $id;
    private $login;
    private $password;
    private $fio;
    private $work;
    private $email;
    private $sex;
    private $birthday;
    private $about;
    private $image;
    private $role;

    function __construct($id, $about, $birthday, $email, $fio,  $image, $login, $password, $sex, $work, $role)
    {
        $this->about = $about;
        $this->birthday = $birthday;
        $this->email = $email;
        $this->fio = $fio;
        $this->id = $id;
        $this->image = $image;
        $this->login = $login;
        $this->password = $password;
        $this->sex = $sex;
        $this->work = $work;
        $this->role = $role;
    }


} 
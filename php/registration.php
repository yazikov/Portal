<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 9/27/14
 * Time: 6:00 PM
 */
register_shutdown_function( "fatal_handler" );

include("../include.php");

$login = $_POST['login'];
$password = $_POST['password'];
$fio = $_POST['fio'];
$birthday = $_POST['birthday'];
$sex = $_POST['sex'];
$email = $_POST['email'];
$work = $_POST['work'];
$about = $_POST['about'];

$dao = new DAO();

$err = array();
# проверям логин
if(!preg_match("/^[a-zA-Z0-9]+$/",$login)) {
    $err[] = "Логин может состоять только из букв английского алфавита и цифр";
}

if(strlen($login) < 3 or strlen($login) > 30) {
    $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
}

# проверяем, не сущестует ли пользователя с таким именем
if ($dao->checkUser($login)) {
    $err[] = "Пользователь с таким логином уже существует в базе данных";
}

# Если нет ошибок, то добавляем в БД нового пользователя
if (count($err) == 0) {
    $login = $_POST['login'];
    # Убераем лишние пробелы и делаем двойное шифрование
    $password = md5(md5(trim($password)));

    $user = new User(null, $about, $birthday, $email, $fio, null, $login, $password, $sex, $work, null);

    $user_id = $dao->saveUser($user);
    setcookie("userid", $user_id, time() + 60 * 60 * 24 );
} else {
    print "<b>При регистрации произошли следующие ошибки:</b><br>";
    foreach($err AS $error) {
        print $error."<br>";
    }
}

$dao->close();

function fatal_handler() {
    $errors = error_get_last();
    foreach($errors as $error) {
        print $error;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 9/20/14
 * Time: 2:19 PM
 */
register_shutdown_function( "fatal_handler" );

include("include.php");

$page_name = $_SERVER['SCRIPT_NAME'];
$category = $_GET['category'];
if(!$category) {
    $category = 1;
}
$active_page = $_GET['page'];
if (!$active_page) {
    $active_page = 1;
}

$dao = new DAO();

$user = null;
if(isset($_COOKIE['userid'])) {
    print $_COOKIE['userid'];
    $user = $dao->getUserById($_COOKIE['userid']);
}

$count = $dao->getTextCount($category);
$page_count = 0;
if ($count > 0) {
    $page_count = (int) ($count/10);
    if ($count % 10 != 0) {
        $page_count++;
    }
}
if ($active_page > $page_count) {
    $active_page = 1;
}

$texts = $dao->getTextPage($category, $active_page);

$template = new Template($user, $active_page, $category, $page_count, $page_name, $texts);

$dao->close();

include("template.html");

function fatal_handler() {
    $errors = error_get_last();
    foreach($errors as $error) {
        print $error;
    }
}


<?php
/**
 * Created by PhpStorm.
 * User: nikolay
 * Date: 9/22/14
 * Time: 10:29 PM
 */

include("../include.php");

$id = $_GET['id'];

register_shutdown_function( "fatal_handler" );

$dao = new DAO();

$advice = $dao->getRandomText(1, $id);

$dao->close();

$array = array('textid' => $advice->getId(), 'text' => $advice->getText());

echo json_encode($array);

function fatal_handler() {
    $errors = error_get_last();
    foreach($errors as $error) {
        print $error;
    }
}
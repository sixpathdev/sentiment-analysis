<?php
require "./logic/utility.php";

if(isset($_POST['submit_post'])) {
    insertDb(trim($_POST['review']));
    header('location: index.php');
}

if(isset($_POST['vote'])) {
    $values = explode('_', $_POST['vote']);
    insertVote($values[0], $values[1]);
    header('location: index.php');
}
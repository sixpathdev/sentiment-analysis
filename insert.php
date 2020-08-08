<?php
require "./logic/utility.php";

if (isset($_POST['submit_post'])) {

    insertDb(trim($_POST['review']));
    header('location: index.php');
}


<?php
require "./logic/utility.php";

if (isset($_POST['submit_post'])) {
    insertDb(trim($_POST['review']));
    header('location: index.php');
}

if (isset($_POST['vote'])) {
    $values = explode('_', $_POST['vote']);
    $ip = getIp();
    $ipExists = verifyIp('positive', trim($values[1]), $ip);
    $ipExists2 = verifyIp('neutral', trim($values[1]), $ip);
    $ipExists3 = verifyIp('negative', trim($values[1]), $ip);
    if ($ipExists[0]['user_ip'] == $ip) {
        $_SESSION['error'] = "Already chosen an option for this post";
        header('location: index.php');
    } elseif ($ipExists2[0]['user_ip'] == $ip) {
        $_SESSION['error'] = "Already chosen an option for this post";
        header('location: index.php');
    } elseif ($ipExists3[0]['user_ip'] == $ip) {
        $_SESSION['error'] = "Already chosen an option for this post";
        header('location: index.php');
    } else {
        insertVote(trim($values[0]), trim($values[1]), $ip);
        header('location: index.php');
    }    
}

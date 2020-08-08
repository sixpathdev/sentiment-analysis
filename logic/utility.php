<?php

session_start();
// error_reporting(0);
// ini_set('display_errors', 0);

if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
}

require_once(realpath(dirname(__FILE__)) . '/MysqliDb.php');
require_once(realpath(dirname(__FILE__)) . '/db.php');
require_once('vendor/autoload.php');
Use Sentiment\Analyzer;

try {
    $db = new MysqliDb($host, $dbusername, $dbpassword, $database);
    if (!$db) die("Database error");
    $db->setTrace(true);
    $db->JsonBuilder()->rawQuery("SHOW TABLES");
} catch (exception $e) {
    output_response("error", "Database connection failed", null);
}

function output_response($state, $message, $data)
{
    $state = $state == strtolower("error") ? 201 : 200;
    $response = array("status" => $state, "message" => $message, "data" => $data);
    http_response_code($state);
    echo json_encode($response);
}

function getPosts()
{
    global $db;
    $getColumn = $db->JsonBuilder()->rawQuery("SELECT * FROM post");
    $response = json_decode($getColumn, true);
    return $response;
}

// function getIp()
// {
//     if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
//         //check for ip from share internet
//         $ip = $_SERVER["HTTP_CLIENT_IP"];
//     } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
//         // Check for the Proxy User
//         $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
//     } else {
//         $ip = $_SERVER["REMOTE_ADDR"];
//     }

//     // This will print user's real IP Address
//     // does't matter if user using proxy or not.
//     return $ip;
// }

function insertDb($body)
{
    $analyzer = new Analyzer();
    global $db;
    $result = $analyzer->getSentiment($body);
    // die(var_dump($result));
    $result_value = max($result);
    // die($result_value);
    $result_key = array_search($result_value, $result);
    $reaction = '';
    if($result_key == 'pos') {
        $reaction =  'positive';
    } elseif($result_key == 'neg') {
        $reaction = 'negative';
    } elseif($result_key == 'compound') {
        $reaction = 'compound';
    } elseif($result_key == 'neu') {
        $reaction = 'neutral';
    }
    $data = array(
        "text" => $body,
        "sentiment" => $reaction
    );
    $db->insert('post', $data);
}

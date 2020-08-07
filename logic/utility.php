<?php

session_start();
// error_reporting(0);
// ini_set('display_errors', 0);

if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
}

require_once(realpath(dirname(__FILE__)) . '/MysqliDb.php');
require_once(realpath(dirname(__FILE__)) . '/db.php');

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

function getIp()
{
    if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
        //check for ip from share internet
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        // Check for the Proxy User
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } else {
        $ip = $_SERVER["REMOTE_ADDR"];
    }

    // This will print user's real IP Address
    // does't matter if user using proxy or not.
    return $ip;
}

function insertDb($body)
{
    global $db;
    $data = array(
        "text" => $body
    );
    $db->insert('post', $data);
}

function verifyIp($table, $post_id, $ip)
{
    global $db;
    $getColumn = $db->JsonBuilder()->rawQuery("SELECT * FROM $table WHERE user_ip = ? AND post_id = ?", array($ip, $post_id));
    $response = json_decode($getColumn, true);
    return $response;
}

function insertVote($table, $post_id, $user_ip)
{
    global $db;
    $data = array(
        "post_id" => $post_id,
        "user_ip" => $user_ip
    );
    $db->insert($table, $data);
}

function vote($table, $post_id)
{
    global $db;
    $getColumn = $db->JsonBuilder()->rawQuery("SELECT * FROM $table WHERE post_id = ?", array($post_id));
    $response = json_decode($getColumn, true);
    return $response;
}

function updateDb($table, $column)
{
    global $db;
    $getColumn = $db->JsonBuilder()->rawQuery("SELECT * FROM analysis");
    $response = json_decode($getColumn, true);
    $updated_value = (int)$response[0]['$column'] + 1;
    $db->JsonBuilder()->rawQuery("UPDATE $table SET $column = ?", array($updated_value));
}

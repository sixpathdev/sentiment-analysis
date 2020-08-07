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

function insertDb($body)
{
    global $db;
    $data = array(
        "text" => $body
    );
    $db->insert('post', $data);
}

function insertVote($table, $post_id)
{
    global $db;
    $data = array(
        "post_id" => $post_id,
        "count" => 1
    );
    $db->insert($table, $data);
}

function vote($table, $post_id)
{
    global $db;
    $getColumn = $db->JsonBuilder()->rawQuery("SELECT * FROM $table WHERE post_id = ?", array($post_id));
    $response = json_decode($getColumn, true);
    return $response;
    // $updated_value = (int)$response[0]['$column'] + 1;
    // $db->JsonBuilder()->rawQuery("UPDATE $table SET 'count' = ? WHERE ", array($updated_value));
}

function updateDb($table, $column)
{
    global $db;
    $getColumn = $db->JsonBuilder()->rawQuery("SELECT * FROM analysis");
    $response = json_decode($getColumn, true);
    $updated_value = (int)$response[0]['$column'] + 1;
    $db->JsonBuilder()->rawQuery("UPDATE $table SET $column = ?", array($updated_value));
}

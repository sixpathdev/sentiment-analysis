<?php

session_start();
error_reporting(0);
ini_set('display_errors', 0);

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

function getPosts($pageNum)
{
    global $db;
    $page = $pageNum;
    $db->pageLimit = 10;
    $response = $db->arraybuilder()->paginate("post", $page);
    return $response;
}


function insertDb($body)
{
    $analyzer = new Analyzer();
    global $db;
    if(empty($body) || strlen($body) < 4) {
        $_SESSION['error'] = "Payload shouldn't be empty";
    }
    $result = $analyzer->getSentiment(htmlspecialchars($body, ENT_QUOTES));
    $result_value = max($result);
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

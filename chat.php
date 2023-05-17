<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


$action = isset($_GET['action']) ? $_GET['action'] : '';
// model name
$model = isset($_GET['model']) ? $_GET['model'] : '';

if ($action == 'conversation') {
	include 'openai.php';
	$openai = new openai();

	$prompt = file_get_contents('php://input');
	if (empty($prompt)) {
		die('{"code":"-2"}');
	}
	$res = $openai->chatCompletions($prompt, $model);
	die($res);
}
if ($action == 'embeddings') {
	include 'openai.php';
	$openai = new openai();
	// post data format: {"content":"xxx"}
	$jsonStr = file_get_contents('php://input');
	if (empty($jsonStr)) {
		die('{"code":"-2"}');
	}
	$text = json_decode($jsonStr);
	if (empty($text) || empty($text['content'])) {
		die('{"code":"-3"}');
	}
	$res = $openai->embeddings($text['content'], $model);
	die($res);
}
die('{"code":"-1"}');

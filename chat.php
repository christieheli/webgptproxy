<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


$action = isset($_GET['action']) ? $_GET['action'] : '';
// model name
$model = isset($_GET['model']) ? $_GET['model'] : '';

if ($action == 'conversation') {
	include 'openai.php';
	$openai = new openai();

	$content = file_get_contents('php://input');
	if (empty($content)) {
		die('{"code":"-2"}');
	}
	$contentArray = json_decode($content, true);
	if (empty($contentArray) || empty($contentArray['prompt'])) {
		die('{"code":"-3"}');
	}
	$prompt = $contentArray['prompt'];
	$functions = $contentArray['functions'];
	$res = $openai->chatCompletions($prompt, $functions, $model);
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
	$text = json_decode($jsonStr, true);
	if (empty($text) || empty($text['content'])) {
		die('{"code":"-3"}');
	}
	$res = $openai->embeddings($text['content'], $model);
	die($res);
}
die('{"code":"-1"}');

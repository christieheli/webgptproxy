<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


$action = isset($_GET['action']) ? $_GET['action'] : '';
// 模型名称
$model = isset($_GET['model']) ? $_GET['model'] : '';

if ($action == 'conversation') {
	include 'openai.php';
	$openai = new openai();

	$prompt = file_get_contents('php://input');
	$res = $openai->chatCompletions($prompt, $model);
	die($res);
}
if ($action == 'embeddings') {
	include 'openai.php';
	$openai = new openai();

	$input = file_get_contents('php://input');
	$res = $openai->embeddings($input, $model);
	die($res);
}
die('{"code":"-1"}');

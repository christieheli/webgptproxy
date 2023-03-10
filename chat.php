<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'conversation') {
	include 'openai.php';
	$openai = new openai();

	$prompt = file_get_contents('php://input');
	$res = $openai->chatCompletions($prompt);
	die($res);
}
die('{"code":"-1"}');

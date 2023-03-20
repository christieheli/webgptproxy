<?php
include 'http.class.php';


class openai {

	const APPKEY = '';
	private $_http;
	
	public function __construct()
	{
		$this->_http = new http();
	}

	public function chatCompletions($prompt)
	{
		$body = [
			'model' => 'gpt-3.5-turbo',
			'messages' => json_decode($prompt),
			'temperature' => 0.8,
		];
		$requestParam = json_encode($body);
		$url = 'https://api.openai.com/v1/chat/completions';
		$this->_http->setHeader('Content-Type', 'application/json');
		$this->_http->setHeader('Authorization', 'Bearer ' .self::APPKEY);
		$retStr = $this->_http->setUrl($url)->setData($requestParam)->request('post', true);
		#var_dump($this->_http->getHttpInfo());
		return $retStr;
	}
}

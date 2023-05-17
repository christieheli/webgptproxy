<?php
include 'http.class.php';


class openai {

	const APPKEY = '';
	private $_http;
	
	public function __construct()
	{
		$this->_http = new http();
	}

	public function chatCompletions($prompt, $model = '')
	{
		$model = isset($model) && !empty($model) ? $model : 'gpt-3.5-turbo';
		$body = [
			'model' => $model,
			'messages' => json_decode($prompt, true),
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
	
	public function embeddings($input, $model = '')
	{
		$model = isset($model) && !empty($model) ? $model : 'text-embedding-ada-002';
		$body = [
			'model' => $model,
			'input' => $input
		];
		$requestParam = json_encode($body);
		$url = 'https://api.openai.com/v1/embeddings';
		$this->_http->setHeader('Content-Type', 'application/json');
		$this->_http->setHeader('Authorization', 'Bearer ' .self::APPKEY);
		$retStr = $this->_http->setUrl($url)->setData($requestParam)->request('post', true);
		#var_dump($this->_http->getHttpInfo());
		return $retStr;
	}
}

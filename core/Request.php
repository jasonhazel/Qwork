<?php

class Request
{
	private $data = array();

	public function __construct()
	{
		$this->data['get'] 		= (object) $_GET;
		$this->data['post'] 	= (object) $_POST;
		$this->data['server'] 	= (object) $_SERVER;
		$this->Filter();

	}

	public function __get($key)
	{
		if(array_key_exists($key, $this->data))
			return $this->data[$key];
		else
			return null;
	}

	private function Filter()
	{
		$filtered 			= new stdClass;
		$filtered->uri 		= $this->server->REQUEST_URI;
		$filtered->method 	= $this->server->REQUEST_METHOD;

		$regex_replace 		= array();
		$regex_replace[] 	= '/^\\' . $this->server->SCRIPT_NAME . "/"; //remvoe script name
		$regex_replace[] 	= '/\?.*$/';	//remove any "get" information
		$regex_replace[] 	= '/\/$/'; 	//remove trailing space
		
		$filtered->uri 		= preg_replace($regex_replace, '', $filtered->uri);

		$filtered->uri 		= ($filtered->uri == '' ? '/' : $filtered->uri);
		$uri_breakdown = explode('/', $filtered->uri);
		array_shift($uri_breakdown);
		
		$controller = ucfirst(strtolower(array_shift($uri_breakdown))) . 'Controller';
		$filtered->controller = (class_exists($controller) ? $controller : 'DefaultController' );

		$filtered->action = 'Index';
		
		if(isset($uri_breakdown[0]))
		{
			$action = ucfirst(strtolower($uri_breakdown[0]));
			if(method_exists($filtered->controller, $action) && $filtered->controller != 'DefaultController')
			{
				$filtered->action = $action;
				array_shift($uri_breakdown);
			}
		}
		$filtered->params 	= $uri_breakdown;
		$this->data['route'] = $filtered;
	}
}
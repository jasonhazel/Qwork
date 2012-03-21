<?php

class Request extends DataStore
{
	// private $data = array();

	public function __construct()
	{
		$this->get 		= (object) $_GET;
		$this->post 	= (object) $_POST;
		$this->server 	= (object) $_SERVER;
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
		
		// break down the request to figure out the routing.
		// filter out null values.
		$uri_breakdown = array_values(array_filter(
							explode('/', $filtered->uri), 
							function($v) {return !empty($v);}
						));
		// $uri_breakdown = array_values($uri_breakdown);

		$controller_name = ucfirst(strtolower($uri_breakdown[0]));

		if(class_exists($controller_name . 'Controller') && !empty($controller_name))
			array_shift($uri_breakdown);
		else
			$controller_name = 'DefaultController';

		$filtered->controller = $controller_name;


		$action_name = ucfirst(strtolower($uri_breakdown[0]));
		if(method_exists($filtered->controller, $action_name))
			$array_shift($uri_breakdown);
		else
			$action_name = 'Index';
		
		$filtered->action = $action_name;

		$filtered->params 	= array_values($uri_breakdown);
		$this->route = $filtered;
	}
}
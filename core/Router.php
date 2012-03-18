<?php

class Router
{
	public $Routes = array();
	public $Request;

	public function __construct()
	{
		$this->Request = new Request;
	}

	public function Register(stdClass $route)
	{
		$this->routes[$route->path] = $route;
	}

	public function Find($path)
	{

	}

	public function Route()
	{
		
		$route = $this->Request->route;
		$controller = new $route->controller;
		$controller->Parameters($route->params);
		$controller->route = $route;
		return $controller->{$route->action}();


	}
}
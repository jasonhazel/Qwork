<?php
define('DOCROOT', dirname(__DIR__));

ini_set('display_errors', 1);

$global_config = array();
$global_config["paths"] = array();

function __autoload($class) {
	global $global_config;
	foreach($global_config['paths'] as $path)
	{
		$class_path = $path . $class . '.php';
		if(file_exists($class_path)) include($class_path);
	}
}

class Qwork
{
	public $Router;

	public function __construct()
	{
		global $global_config;
		$config_ini = parse_ini_file(DOCROOT . '/config.ini', true);
		foreach($config_ini['paths'] as $key => $val)
			$global_config['paths'][$key] = DOCROOT . "/$val/";
		$this->Router 	= new Router;
	}

	public function Run()
	{
		return $this->Router->Route();
	}
}

$Q = new Qwork;
$Q->Run()->Render();
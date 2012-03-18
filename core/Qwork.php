<?php

define('DOCROOT', dirname(__DIR__));

require(DOCROOT . '/core/DataStore.php');

// ini_set('display_errors', 1);

function __autoload($class) { Qwork::autoload($class); }

class Qwork
{
	public $Router;
	private static $data;

	public function __construct()
	{
		self::$data = new DataStore;
		$this->Config('config.ini');
		$this->Router 	= new Router;
		
	}

	public static function autoload($class)
	{
		foreach(self::$data->paths as $path)
		{
			$class_path = DOCROOT . "$path/$class.php";
			if(file_exists($class_path)) include($class_path);
		}
	}

	public function Config($filename = null)
	{
		if($ini = parse_ini_file(DOCROOT . '/' . $filename, true))
			foreach($ini as $key => $val)
				self::$data->$key =  $val;

		return $this;

	}

	public function Run()
	{
		return $this->Router->Route();
	}
}

$Q = new Qwork;
$Q->Run()->Render();
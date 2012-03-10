<?php
define('DOCROOT', dirname(__DIR__));

ini_set('display_errors', 1);

function __autoload($class) {
	$locations = array(
		"core"			=> DOCROOT . "/core/$class.php",
		"interfaces"	=> DOCROOT . "/core/interfaces/$class.php",
		"controllers" 	=> DOCROOT . "/controllers/$class.php",
		"models"		=> DOCROOT . "/models/$class.php",
		"views"			=> DOCROOT . "/views/$class.php"
	);
	foreach($locations as $path)
		if(file_exists($path)) include($path);
}

class Qwork
{
	public $Router;

	public function __construct()
	{
		$this->Router 	= new Router;
	}

	public function Run()
	{
		return $this->Router->Route();
	}
}

$Q = new Qwork;
$Q->Run()->Render();
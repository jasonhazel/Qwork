<?php

class DefaultController extends Controller
{
	protected $param_keys = array(
							1 => array('name'),
							2 => array('first','last')
							);


	public function Index()
	{
		switch($this->params->count())
		{
			case 0:
				$msg = 'Hello, World';
			break;
			case 1:
				$msg = 'Hello, ' . $this->params->name;
			break;
			case 2:
				$msg = 'Hello, ' . ucfirst($this->params->first) . ' ' . ucfirst($this->params->last); 
			break;
		}

		$this->view->Set('message', $msg);
		return $this;
	}
}
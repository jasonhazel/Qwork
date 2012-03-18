<?php
abstract class Controller
{
	protected $view;
	protected $params;
	protected $param_keys;

	public function __construct()
	{
		$this->view = new View;
	}

	public function Name()
	{
		return str_replace('Controller','',get_called_class());
	}

	public function Parameters($params)
	{
		$this->params = new DataStore;
		$index = count($params);
		if(!empty($this->param_keys[$index]))
		{
			foreach($this->param_keys[$index] as $key => $val)
			{
				$val = strtolower($val);
				$this->params->$val = $params[$key];
			}
		}
	}

	public function Render($view = null)
	{
		if($view)
		{
			$action_view = strtolower($view);
			if(substr(strtolower($action_view), -4) != '.tpl')
				$action_view .= '.tpl';
		}
		else
			$action_view = $this->Name() . '/' . $this->route->action . '.tpl';

		$application_view = DOCROOT . '/views/application.tpl';
		$this->view->Set('action', $this->view->Render(DOCROOT . '/views/' . strtolower($action_view), false));
		$this->view->Render($application_view);
	}
}
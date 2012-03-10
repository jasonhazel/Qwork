<?php
abstract class Controller
{

	public function Name()
	{
		return str_replace('Controller','',get_called_class());
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


		$action_view 		= DOCROOT . '/views/' . strtolower($action_view);
		$application_view 	= DOCROOT . '/views/application.tpl';
		
		if(file_exists($action_view) && file_exists($application_view))
			include($application_view);
		else
			throw new Exception("Invalid View");
	}
}
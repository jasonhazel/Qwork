<?php
class View
{

	private $data = array();

	public function Remove($key)
	{
		if(isset($this->data[$key]))
			unset($this->data[$key]);

		return $this;
	}

	public function Set($key, $val)
	{
		$this->data[$key] = $val;
		return $this;
	}

	public function Render($path = null, $display = true)
	{
		$template_path = $this->path;
		if($path)
			$template_path = $path;

		$keys = array_keys($this->data);
		$vars = array_map(function($v){return '{{@'.strtoupper($v).'}}';}, $keys);

		if($template = file_get_contents($template_path))
		{
			$template = str_replace($vars, $this->data, $template);
			if($display)
				echo $template;
			else
				return $template;
		}
		else
			return false;
		
	}

}
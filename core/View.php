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

	public function Path($path = null)
	{
		if($path)
			$this->path = $path;
		else
			return $this->path;
		return $this;
	}

	public function Render()
	{
		
	}

}
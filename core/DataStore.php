<?php
class DataStore
{
	protected $data = array();

	public function __get($key)
	{
		if(!array_key_exists($key, $this->data))
			$this->data[$key] = null;

		return $this->data[$key];
	}

	public function __set($key, $value)
	{
		$this->data[$key] = $value;
	}

	public function __toString()
	{
		return print_r($this->data, true);
	}

	public function count($key = null)
	{
		if($key)
		{
			$val = $this->$key;
			switch(true)
			{
				case is_array($val):
					return count($val);
				break;

			}
			return 0;
		}
		else
			return count($this->data, COUNT_RECURSIVE);
	}
}
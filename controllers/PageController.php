<?php

class PageController extends Controller
{
	public function Index()
	{
		return $this;
	}

	public function Test()
	{
		return $this;
	}

	public function Hello()
	{
		$this->view->Set('name',ucfirst($this->params[0]));
		return $this;
	}
}
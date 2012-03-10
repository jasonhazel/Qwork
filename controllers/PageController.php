<?php

class PageController extends Controller
{
	public function DefaultAction()
	{
		print_r($this->params);

		return $this;
	}


	public function Test()
	{
		return $this;
	}





}
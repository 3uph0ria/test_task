<?php

namespace App\Controllers;
use \App\Models\Comments_model;

class Home extends BaseController
{
	public function index()
	{
		return view('Home/index.php');
	}
}

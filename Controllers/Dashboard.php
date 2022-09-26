<?php

class Dashboard extends Controllers
{
	public function __construct()
	{
		parent::__construct();
		session
		//session_regenerate_id(true);
		if (empty($_SESSION['login'])) {
			header('Location: ' . base_url() . '/login');
			die();
		}
		getPermisos(MDASHBOARD);
	}
<?php

class BaseController{

	protected $framework;
	protected $db;

	function __construct() {
		$f3=Base::instance();

		# Connect to Mysql:
		/*try {
			$db=new DB\SQL(
			'mysql:host=localhost;port=3306;dbname='.$f3->get('dbname'), $f3->get('dbuser'),$f3->get('dbpasswd'));
		} catch (Exception $e) {
			die("Connection error!");
		}

		$this->db=$db;*/

		$this->framework=$f3;
	}

	function afterRoute(){
	 	$this->layout();
	}

	function layout(){
		echo Template::instance()->render($this->framework->get('layout'));
	}
}

<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Build extends CI_Controller{

	public function __construct() {
		parent::__construct();
		
	}

	public function index() {
		$this->access->redirect('login');
	}

	public function initializing() {
		$this->access->redirect('first');
	}
}
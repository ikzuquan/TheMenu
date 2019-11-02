<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kiosk extends CI_Controller
{
	public $data = [];

	public function __construct()
	{
		parent::__construct();

		$this->load->model('devices_model');
		$this->load->model('menus_model');
		$this->load->model('signages_model');
	}

	public function test($mac_address){
		if(empty($mac_address)){
			die(0);
		}
		$this->data['device'] = $this->devices_model->get_device($mac_address);
		if(empty((array) $this->data['device'])) die(0);

		$this->data['menus'] = $this->menus_model->get_menus_bydevice($this->data['device']->id);
		$this->data['signages'] = $this->signages_model->get_signages_bydevice($this->data['device']->id);
		$kiosk["signages"] = (array) $this->data['signages'];
		$kiosk["menus"] = (array) $this->data['menus'];
		echo json_encode($kiosk);
	}


}

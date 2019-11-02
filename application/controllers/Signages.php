<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signages extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

    public function __construct()
	{
        parent::__construct();
        $this->load->database();
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language']);
		$this->load->model('devices_model');
		$this->load->model('companies_model');
		$this->load->model('signages_model');

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
        if (!$this->ion_auth->logged_in())
        {
                // redirect them to the login page
                redirect('auth/login', 'refresh');
        }


    }

	public function index()
	{
		$user = $this->ion_auth->user()->row();
		$this->data['page'] = "signages";
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['error'] = $this->session->flashdata('error');
		$this->data['title'] = "signages";

		//list the users
		
		$this->data['devices'] = $this->devices_model->get_devices_bycompany($user->company);
			
        $this->load->view('templates' . DIRECTORY_SEPARATOR . 'header', $this->data);
        $this->load->view('templates' . DIRECTORY_SEPARATOR . 'user_side', $this->data);
        $this->load->view('signages'. DIRECTORY_SEPARATOR . 'index', $this->data);
        $this->load->view('templates' . DIRECTORY_SEPARATOR . 'adminfooter', $this->data);
        $this->load->view('templates' . DIRECTORY_SEPARATOR . 'footer', $this->data);
	}

	public function change_order($device_id){
		$user = $this->ion_auth->user()->row();
		//check if the device is own by the user or device not found
		$this->data['device'] = $this->devices_model->get_devices($device_id);
		if(empty($this->data['device']->company_id)){
			echo 0;
			die();
		} else if($this->data['device']->company_id != $user->company) {
			echo 0;
			die();
		}
		if (empty($this->input->post('from'))||empty($this->input->post('to')))
		{
			echo 0;
			die();
		}
		$from = (int) $this->input->post('from');
		$to = (int) $this->input->post('to');
		if($this->signages_model->change_signage_order($from, $to, $device_id)){
			echo 1;
			die();
		} else {
			echo 0;
			die();
		}
		
	}

	public function remove_order($device_id){
		$user = $this->ion_auth->user()->row();
		//check if the device is own by the user or device not found
		$this->data['device'] = $this->devices_model->get_devices($device_id);
		if(empty($this->data['device']->company_id)){
			echo 0;
			die();
		} else if($this->data['device']->company_id != $user->company) {
			echo 0;
			die();
		}
		if (empty($this->input->post('order')))
		{
			echo 0;
			die();
		}
		$order = (int) $this->input->post('order');
		if($this->signages_model->remove_order($order, $device_id)){
			echo 1;
			die();
		} else {
			echo 0;
			die();
		}
		
	}

	public function edit_signage($device_id)
	{
		$user = $this->ion_auth->user()->row();
		$this->data['page'] = "signages";
		$this->data['device_id'] = $device_id;
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['error'] = $this->session->flashdata('error');
		$this->data['title'] = "signages";
		
		//check if the device is own by the user or device not found
		$this->data['device'] = $this->devices_model->get_devices($device_id);
		if(empty($this->data['device']->company_id)){
			show_error("Invalid Request");
		} else if($this->data['device']->company_id != $user->company) {
			show_error("Invalid Request");
		}
		//get signages based on device
		$this->data['signages'] = $this->signages_model->get_signages_bydevice($this->data['device']->id);
			
        $this->load->view('templates' . DIRECTORY_SEPARATOR . 'header', $this->data);
        $this->load->view('templates' . DIRECTORY_SEPARATOR . 'user_side', $this->data);
        $this->load->view('signages'. DIRECTORY_SEPARATOR . 'edit_signage', $this->data);
        $this->load->view('templates' . DIRECTORY_SEPARATOR . 'adminfooter', $this->data);
        $this->load->view('templates' . DIRECTORY_SEPARATOR . 'footer', $this->data);
	}

	public function update_time($device_id)
	{
		$user = $this->ion_auth->user()->row();
		//check if the device is own by the user or device not found
		$this->data['device'] = $this->devices_model->get_devices($device_id);
		if(empty($this->data['device']->company_id)){
			show_error("Invalid Request");
		} else if($this->data['device']->company_id != $user->company) {
			show_error("Invalid Request");
		}
		if (empty($this->input->post('update_start_time'))||empty($this->input->post('update_end_time'))||empty($this->input->post('update_time_order')))
		{
			show_error("Invalid Request");
		}
		$order = (int) $this->input->post('update_time_order');
		$start_time = $this->input->post('update_start_time');
		$end_time = $this->input->post('update_end_time');
		if($this->signages_model->update_time($order, $device_id,$start_time,$end_time)){
			$message = "Time updated successfully";
			$this->session->set_flashdata('message', $message);
			redirect("signages/edit_signage/".$device_id, 'refresh');
		} else {
			$error = "Unable to update the time, please try again later";
			$this->session->set_flashdata('error', $error);
			redirect("signages/edit_signage/".$device_id, 'refresh');
		}

	}

	public function upload_signage($device_id) { 
		$user = $this->ion_auth->user()->row();
		//check if the device is own by the user or device not found
		$this->data['device'] = $this->devices_model->get_devices($device_id);
		if(empty($this->data['device']->company_id)){
			show_error("Invalid Request");
		} else if($this->data['device']->company_id != $user->company) {
			show_error("Invalid Request");
		}
		if ($device_id != $this->input->post('id'))
		{
			show_error("Invalid Request");
			
		}
		$data = [];
		$error = '';
		
		$count = count($_FILES['filename']['name']);

        $max_rank = $this->signages_model->get_max_order_rank($device_id) + 1;


		for($i=0;$i<$count;$i++){

			
		  if(!empty($_FILES['filename']['name'][$i])){
			
			$_FILES['file']['name'] = $_FILES['filename']['name'][$i];
			$_FILES['file']['type'] = $_FILES['filename']['type'][$i];
			$_FILES['file']['tmp_name'] = $_FILES['filename']['tmp_name'][$i];
			$_FILES['file']['error'] = $_FILES['filename']['error'][$i];
			$_FILES['file']['size'] = $_FILES['filename']['size'][$i];
			
			$config['upload_path'] = './uploads/signages'; 
			$config['allowed_types'] = 'jpg|jpeg|png|mp4';
			$config['max_size'] = '50000';
			$config['file_name'] = $_FILES['filename']['name'][$i];
			$config['encrypt_name']     = TRUE;
			
			$this->load->library('upload',$config); 
			
			if($this->upload->do_upload('file')){
			  $filedata = $this->upload->data();
			  $data = array(
				'filename' => $filedata["file_name"],
				'client_name' => $filedata["client_name"],
				'file_size' => $filedata["file_size"]*1000,
				'file_type' => $filedata["file_type"],
				'device_id' => $this->input->post('id'),
				'order_rank' => $max_rank+$i
				);
				if(!$this->signages_model->set_signages($data)){
					show_error("Invalid Request");
				} 
			} else {
				$error = $this->upload->display_errors();
				$this->session->set_flashdata('error', $error);
				redirect("signages/edit_signage/".$this->input->post('id'), 'refresh');
			}
		  }
	 
		}
		$this->session->set_flashdata('message', "Software Created Successfully");
		redirect("signages/edit_signage/".$this->input->post('id'), 'refresh');
	 }


}

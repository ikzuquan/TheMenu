<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Devices extends CI_Controller {

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

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
        if (!$this->ion_auth->logged_in()  || !$this->ion_auth->is_admin())
        {
                // redirect them to the login page
                redirect('auth/login', 'refresh');
        }


    }

	public function index()
	{
		$this->data['page'] = "devices";
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['title'] = "Devices";

		//list the users
		$this->data['devices'] = $this->devices_model->get_devices();

		foreach ($this->data['devices'] as $k => $device)
		{
			$this->data['devices'][$k]["company_id"] = $this->companies_model->get_companies($device["company_id"]);
		}
			
        $this->load->view('templates' . DIRECTORY_SEPARATOR . 'header', $this->data);
        $this->load->view('templates' . DIRECTORY_SEPARATOR . 'side', $this->data);
        $this->load->view('devices'. DIRECTORY_SEPARATOR . 'index', $this->data);
        $this->load->view('templates' . DIRECTORY_SEPARATOR . 'adminfooter', $this->data);
        $this->load->view('templates' . DIRECTORY_SEPARATOR . 'footer', $this->data);
	}

	/**
	 * Create a new user
	 */
	public function create_device()
	{
		$this->data['title'] = "Create Device";
		
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('/', 'refresh');
		}
		
		// validate form input
		
		$this->form_validation->set_rules('mac_address', "Mac Address", 'trim|required|strtoupper|is_unique[devices.mac_address]');
		$this->form_validation->set_rules('company_id', "Company Name", 'trim|required');
		$this->form_validation->set_rules('installation_address', "Installation Address", 'trim|required|strtoupper');
		$this->form_validation->set_rules('installation_date', "Installation Date", 'trim|required|strtoupper');
		$this->form_validation->set_rules('pic_name', "PIC Name", 'trim|strtoupper');
		$this->form_validation->set_rules('pic_contact', "PIC Contact", 'trim|strtoupper');
		$this->form_validation->set_rules('working_day', "Working Day", 'trim|required|strtoupper');
		
		if ($this->form_validation->run() === TRUE)
		{
			// check to see if we are creating the user
			// redirect them back to the admin page
			$data = array(
                'mac_address' => strtoupper($this->input->post('mac_address')),
                'company_id' => strtoupper($this->input->post('company_id')),
                'installation_address' => strtoupper($this->input->post('installation_address')),
				'installation_date' => $this->input->post('installation_date'),
				'pic_name' => strtoupper($this->input->post('pic_name')),
				'pic_contact' => strtoupper($this->input->post('pic_contact')),
				'working_day' => strtoupper($this->input->post('working_day'))
            );
			if($this->devices_model->set_device($data)){
				$this->session->set_flashdata('message', "Device Created Successfully");
				redirect("devices", 'refresh');
			} else {
				$this->data['message'] = "Unable to create device, please try again";
			}
			
		}
		else
		{
			// display the create user form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
		}
			$this->data['mac_address'] = [
				'name' => 'mac_address',
				'id' => 'mac_address',
				'type' => 'text',
				'class' => 'form-control form-control-user',
				'value' => $this->form_validation->set_value('mac_address'),
				'required'=>'yes'
			];
			$company_data = $this->companies_model->get_companies(false, 'company_name');
			$CompanyArray = array();
			foreach ($company_data as $company)
			{
				$CompanyArray[$company["id"]] = $company["company_name"];
			}
			$CompanyArray[NULL] = NULL;
			
			$this->data['company_id'] = [
				'name' => 'company_id',
				'id'   => 'company_id',
				'data' => $CompanyArray,
			];
			$this->data['installation_address'] = [
				'name' => 'installation_address',
				'id' => 'installation_address',
				'type' => 'text',
				'class' => 'form-control form-control-user',
				'value' => $this->form_validation->set_value('installation_address'),
				'placeholder' => 'E.g: Pearl Point, Ground Floor, Powerplant',
				'required'=>'yes'
			];
			$this->data['installation_date'] = [
				'name' => 'installation_date',
				'id' => 'installation_date',
				'type' => 'date',
				'class' => 'form-control form-control-user',
				'value' => $this->form_validation->set_value('installation_date'),
				'required'=>'yes'
			];
			$this->data['pic_name'] = [
				'name' => 'pic_name',
				'id' => 'pic_name',
				'type' => 'text',
				'class' => 'form-control form-control-user',
				'value' => $this->form_validation->set_value('pic_name')
			];
			$this->data['pic_contact'] = [
				'name' => 'pic_contact',
				'id' => 'pic_contact',
				'type' => 'text',
				'class' => 'form-control form-control-user',
				'value' => $this->form_validation->set_value('pic_contact')
			];
			$this->data['working_day'] = [
				'name' => 'working_day',
				'id' => 'working_day',
				'type' => 'text',
				'class' => 'form-control form-control-user',
				'value' => $this->form_validation->set_value('working_day'),
				'placeholder' => "E.g:\nMon to Sat: 9am - 5pm\nSun: 9am - 2pm",
				'required'=>'yes'
			];
			$this->data['page'] = "devices";
			$this->load->view('templates' . DIRECTORY_SEPARATOR . 'header', $this->data);
			$this->load->view('templates' . DIRECTORY_SEPARATOR . 'side', $this->data);
			$this->load->view('devices'. DIRECTORY_SEPARATOR . 'create_device', $this->data);
			$this->load->view('templates' . DIRECTORY_SEPARATOR . 'adminfooter', $this->data);
			$this->load->view('templates' . DIRECTORY_SEPARATOR . 'footer', $this->data);
	}

	/**
	 * Edit a user
	 *
	 * @param int|string $id
	 */
	public function edit_device($id)
	{
		$this->data['title'] = "Edit Device";

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('/', 'refresh');
		}

		$device =  $this->devices_model->get_devices($id);
			
		//USAGE NOTE - you can do more complicated queries like this
		//$groups = $this->ion_auth->where(['field' => 'value'])->groups()->result_array();
		
		//check if device's mac_address changed
		if($device->mac_address != $this->input->post('mac_address')){
			$this->form_validation->set_rules('mac_address', "Mac Address", 'trim|required|strtoupper|is_unique[devices.mac_address]');
		}

		$this->form_validation->set_rules('company_id', "Company Name", 'trim|required');
		$this->form_validation->set_rules('installation_address', "Installation Address", 'trim|required|strtoupper');
		$this->form_validation->set_rules('installation_date', "Installation Date", 'trim|required|strtoupper');
		$this->form_validation->set_rules('pic_name', "PIC Name", 'trim|strtoupper');
		$this->form_validation->set_rules('pic_contact', "PIC Contact", 'trim|strtoupper');
		$this->form_validation->set_rules('working_day', "Working Day", 'trim|required|strtoupper');
		
		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?
			if ($id != $this->input->post('id'))
			{
				show_error("Invalid Request");
				
			}
			if ($this->form_validation->run() === TRUE)
			{

				$data = array(
					'mac_address' => strtoupper($this->input->post('mac_address')),
					'company_id' => strtoupper($this->input->post('company_id')),
					'installation_address' => strtoupper($this->input->post('installation_address')),
					'installation_date' => $this->input->post('installation_date'),
					'pic_name' => strtoupper($this->input->post('pic_name')),
					'pic_contact' => strtoupper($this->input->post('pic_contact')),
					'working_day' => strtoupper($this->input->post('working_day')),
					'active' => $this->input->post('status'),
				);
				// check to see if we are updating the device
				if ($this->devices_model->update_device($id,$data))
				{
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', 'Device Updated Successfully');
					redirect('devices/', 'refresh');

				}
				else
				{
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', 'Error Updating Device');
					redirect('devices/', 'refresh');

				}

			}
		}

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['device'] = $device;

		$this->data['mac_address'] = [
			'name' => 'mac_address',
			'id' => 'mac_address',
			'type' => 'text',
			'class' => 'form-control form-control-user',
			'value' => $this->form_validation->set_value('mac_address', $device->mac_address),
			'required'=>'yes'
		];
		$company_data = $this->companies_model->get_companies(false, 'company_name');
		$CompanyArray = array();
		foreach ($company_data as $company)
		{
			$CompanyArray[$company["id"]] = $company["company_name"];
		}
		$CompanyArray[NULL] = NULL;
		
		$this->data['company_id'] = [
			'name' => 'company_id',
			'id'   => 'company_id',
			'data' => $CompanyArray,
			'value' => $device->company_id,
		];
		$this->data['installation_address'] = [
			'name' => 'installation_address',
			'id' => 'installation_address',
			'type' => 'text',
			'class' => 'form-control form-control-user',
			'value' => $this->form_validation->set_value('installation_address', $device->installation_address),
			'placeholder' => 'E.g: Pearl Point, Ground Floor, Powerplant',
			'required'=>'yes',
		];
		$this->data['installation_date'] = [
			'name' => 'installation_date',
			'id' => 'installation_date',
			'type' => 'date',
			'class' => 'form-control form-control-user',
			'value' => $this->form_validation->set_value('installation_date', $device->installation_date),
			'required'=>'yes'
		];
		$this->data['pic_name'] = [
			'name' => 'pic_name',
			'id' => 'pic_name',
			'type' => 'text',
			'class' => 'form-control form-control-user',
			'value' => $this->form_validation->set_value('pic_name', $device->pic_name)
		];
		$this->data['pic_contact'] = [
			'name' => 'pic_contact',
			'id' => 'pic_contact',
			'type' => 'text',
			'class' => 'form-control form-control-user',
			'value' => $this->form_validation->set_value('pic_contact', $device->pic_contact)
		];
		$this->data['working_day'] = [
			'name' => 'working_day',
			'id' => 'working_day',
			'type' => 'text',
			'class' => 'form-control form-control-user',
			'value' => $this->form_validation->set_value('working_day', $device->working_day),
			'placeholder' => "E.g:\nMon to Sat: 9am - 5pm\nSun: 9am - 2pm",
			'required'=>'yes'
		];
		$this->data['status'] = [
			'name' => 'active',
			'id'   => 'active',
			'data' => array(
				0         => 'Inactive',
				1           => 'Active'
			),
			'value' => $device->active,
		];

		$this->data['page'] = "devices";
		$this->load->view('templates' . DIRECTORY_SEPARATOR . 'header', $this->data);
		$this->load->view('templates' . DIRECTORY_SEPARATOR . 'side', $this->data);
		$this->load->view('devices'. DIRECTORY_SEPARATOR . 'edit_device', $this->data);
		$this->load->view('templates' . DIRECTORY_SEPARATOR . 'adminfooter', $this->data);
		$this->load->view('templates' . DIRECTORY_SEPARATOR . 'footer', $this->data);
	}

}

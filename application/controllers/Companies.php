<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Companies extends CI_Controller {

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
		$this->data['page'] = "companies";
		$this->data['message'] = $this->session->flashdata('message');
		$this->data['title'] = "Companies";

		//list the users
		$this->data['companies'] = $this->companies_model->get_companies();
			
        $this->load->view('templates' . DIRECTORY_SEPARATOR . 'header', $this->data);
        $this->load->view('templates' . DIRECTORY_SEPARATOR . 'side', $this->data);
        $this->load->view('companies'. DIRECTORY_SEPARATOR . 'index', $this->data);
        $this->load->view('templates' . DIRECTORY_SEPARATOR . 'adminfooter', $this->data);
        $this->load->view('templates' . DIRECTORY_SEPARATOR . 'footer', $this->data);
	}

	/**
	 * Create a new user
	 */
	public function create_company()
	{
		$this->data['title'] = "Create Company";

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('/', 'refresh');
		}

		// validate form input
		$this->form_validation->set_rules('company_name', "Company Name", 'trim|required|strtoupper|is_unique[companies.company_name]');
		$this->form_validation->set_rules('ssm_no', "SSM No", 'trim|required|strtoupper|is_unique[companies.ssm_no]');
		$this->form_validation->set_rules('address', "Address", 'trim|required|strtoupper');
		$this->form_validation->set_rules('hotline', "Hotline", 'trim|required|strtoupper');
		
		if ($this->form_validation->run() === TRUE)
		{
			// check to see if we are creating the user
			// redirect them back to the admin page
			if($this->companies_model->set_company()){
				$this->session->set_flashdata('message', "Company Created Successfully");
				redirect("companies", 'refresh');
			} else {
				$this->data['message'] = "Unable to create Company, please try again";
			}
			
		}
		else
		{
			// display the create user form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
		}
			

			$this->data['company_name'] = [
				'name' => 'company_name',
				'id' => 'company_name',
				'type' => 'text',
				'class' => 'form-control form-control-user',
				'value' => $this->form_validation->set_value('company_name'),
				'required'=>'yes'
			];
			$this->data['ssm_no'] = [
				'name' => 'ssm_no',
				'id' => 'ssm_no',
				'type' => 'text',
				'class' => 'form-control form-control-user',
				'value' => $this->form_validation->set_value('ssm_no'),
				'required'=>'yes'
			];
			$this->data['address'] = [
				'name' => 'address',
				'id' => 'address',
				'type' => 'text',
				'class' => 'form-control form-control-user',
				'value' => $this->form_validation->set_value('address'),
				'required'=>'yes'
			];
			$this->data['hotline'] = [
				'name' => 'hotline',
				'id' => 'hotline',
				'type' => 'text',
				'class' => 'form-control form-control-user',
				'value' => $this->form_validation->set_value('hotline'),
				'required'=>'yes'
			];
			$this->data['page'] = "companies";
			$this->load->view('templates' . DIRECTORY_SEPARATOR . 'header', $this->data);
			$this->load->view('templates' . DIRECTORY_SEPARATOR . 'side', $this->data);
			$this->load->view('companies'. DIRECTORY_SEPARATOR . 'create_company', $this->data);
			$this->load->view('templates' . DIRECTORY_SEPARATOR . 'adminfooter', $this->data);
			$this->load->view('templates' . DIRECTORY_SEPARATOR . 'footer', $this->data);
	}

	/**
	 * Edit a user
	 *
	 * @param int|string $id
	 */
	public function edit_company($id)
	{
		$this->data['title'] = "Edit Company";

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('/', 'refresh');
		}

		$company =  $this->companies_model->get_companies($id);
			
		//USAGE NOTE - you can do more complicated queries like this
		//$groups = $this->ion_auth->where(['field' => 'value'])->groups()->result_array();
		
		//check if company's email changed
		if($company->company_name != $this->input->post('company_name')){
			$this->form_validation->set_rules('company_name', "Company Name", 'trim|required|strtoupper|is_unique[companies.company_name]');
		}

		if($company->ssm_no != $this->input->post('ssm_no')){
			$this->form_validation->set_rules('ssm_no', "SSM No", 'trim|required|strtoupper|is_unique[companies.ssm_no]');
		}

		$this->form_validation->set_rules('address', "Address", 'trim|required|strtoupper');
		$this->form_validation->set_rules('hotline', "Hotline", 'trim|required|strtoupper');
		
		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?
			if ($id != $this->input->post('id'))
			{
				show_error("Invalid Request");
				
			}

			if ($this->form_validation->run() === TRUE)
			{


				// check to see if we are updating the company
				if ($this->companies_model->update_company($id))
				{
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', 'Company Updated Successfully');
					redirect('companies/', 'refresh');

				}
				else
				{
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', 'Error Updating Company');
					redirect('companies/', 'refresh');

				}

			}
		}

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['company'] = $company;

		$this->data['company_name'] = [
			'name'  => 'company_name',
			'id'    => 'company_name',
			'type'  => 'text',
			'class' => 'form-control form-control-user',
			'value' => $this->form_validation->set_value('company_name', $company->company_name),
		];
		$this->data['ssm_no'] = [
			'name'  => 'ssm_no',
			'id'    => 'ssm_no',
			'type'  => 'text',
			'class' => 'form-control form-control-user',
			'value' => $this->form_validation->set_value('ssm_no', $company->ssm_no),
		];
		$this->data['address'] = [
			'name'  => 'address',
			'id'    => 'address',
			'type'  => 'text',
			'class' => 'form-control form-control-user',
			'value' => $this->form_validation->set_value('address', $company->address),
		];
		$this->data['hotline'] = [
			'name'  => 'hotline',
			'id'    => 'hotline',
			'type'  => 'text',
			'class' => 'form-control form-control-user',
			'value' => $this->form_validation->set_value('hotline', $company->hotline),
		];
		$this->data['status'] = [
			'name' => 'active',
			'id'   => 'active',
			'data' => array(
				0         => 'Inactive',
				1           => 'Active'
			),
			'value' => $company->active,
		];

		$this->data['page'] = "companies";
		$this->load->view('templates' . DIRECTORY_SEPARATOR . 'header', $this->data);
		$this->load->view('templates' . DIRECTORY_SEPARATOR . 'side', $this->data);
		$this->load->view('companies'. DIRECTORY_SEPARATOR . 'edit_company', $this->data);
		$this->load->view('templates' . DIRECTORY_SEPARATOR . 'adminfooter', $this->data);
		$this->load->view('templates' . DIRECTORY_SEPARATOR . 'footer', $this->data);
	}

}

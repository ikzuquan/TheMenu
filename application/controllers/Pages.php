<?php
class Pages extends CI_Controller {
        public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language']);

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
        }

    public function companies(){
        if (!$this->ion_auth->logged_in())
        {
                // redirect them to the login page
                redirect('auth/login', 'refresh');
        }

        $this->data['page'] = "companies";
			
	$this->load->view('templates' . DIRECTORY_SEPARATOR . 'header', $this->data);
	$this->load->view('templates' . DIRECTORY_SEPARATOR . 'side', $this->data);
	$this->load->view('pages' . DIRECTORY_SEPARATOR . 'home', $this->data);
	$this->load->view('templates' . DIRECTORY_SEPARATOR . 'adminfooter', $this->data);
        $this->load->view('templates' . DIRECTORY_SEPARATOR . 'footer', $this->data);
    }

    public function users(){
        if (!$this->ion_auth->logged_in())
        {
                // redirect them to the login page
                redirect('auth/login', 'refresh');
        }

        $this->data['page'] = "users";
			
	$this->load->view('templates' . DIRECTORY_SEPARATOR . 'header', $this->data);
	$this->load->view('templates' . DIRECTORY_SEPARATOR . 'side', $this->data);
	$this->load->view('pages' . DIRECTORY_SEPARATOR . 'home', $this->data);
	$this->load->view('templates' . DIRECTORY_SEPARATOR . 'adminfooter', $this->data);
        $this->load->view('templates' . DIRECTORY_SEPARATOR . 'footer', $this->data);
    }

    public function devices(){
        if (!$this->ion_auth->logged_in())
        {
                // redirect them to the login page
                redirect('auth/login', 'refresh');
        }

        $this->data['page'] = "devices";
			
	$this->load->view('templates' . DIRECTORY_SEPARATOR . 'header', $this->data);
	$this->load->view('templates' . DIRECTORY_SEPARATOR . 'side', $this->data);
	$this->load->view('pages' . DIRECTORY_SEPARATOR . 'home', $this->data);
	$this->load->view('templates' . DIRECTORY_SEPARATOR . 'adminfooter', $this->data);
        $this->load->view('templates' . DIRECTORY_SEPARATOR . 'footer', $this->data);
    }
}
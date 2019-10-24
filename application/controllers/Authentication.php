<?php

Class Authentication extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Load form helper library
        $this->load->helper('form');

        // Load form validation library
        $this->load->library('form_validation');

        // Load database
        $this->load->model('login_model');
        $this->load->library('ion_auth');
    }

    // Show login page
    public function index() {
        $this->load->view('pages/login');
    }

    // Show login page
    public function forgotpassword() {
        $this->load->view('pages/resetpassword');
    }

    // Check for user login process
    public function user_login_process() {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[7]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            if(isset($this->session->userdata['logged_in'])){
                $this->load->view('pages/home');
            }else{
                $this->load->view('pages/login');
            }
        } else {
            $data = array(
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password')
                );
            $result = $this->login_model->login($data);
            if ($result == TRUE) {

                $email = $this->input->post('email');
                $result = $this->login_model->read_user_information($email);
                if ($result != false) {
                    $session_data = array(
                    'email' => $result[0]->user_email,
                    );
                    // Add user data in session
                    $this->session->set_userdata('logged_in', $session_data);
                    if($this->input->post('rememberme')=="yes"){
                        $this->session->sess_expiration = '604800';// expires in 7 days
                    } else {
                        $this->session->sess_expiration = '14400';// expires in 4 hours
                    }
                    redirect('welcome');
                }
            } else {
                $data = array(
                'error_message' => 'Invalid Username or Password'
                );
                $this->load->view('pages/login', $data);
            }
        }
    }

    // Logout from admin page
    public function logout() {
        // Removing session data
        $sess_array = array(
        'username' => ''
        );
        $this->session->unset_userdata('logged_in', $sess_array);
        $data['message_display'] = 'Successfully Logout';
        $this->load->view('pages/login', $data);
    }

}

?>
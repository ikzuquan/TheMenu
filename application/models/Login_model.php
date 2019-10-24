<?php

Class Login_Model extends CI_Model {

    // Read data using username and password
    public function login($data) {
        
        $query = $this->db->get_where('user_login', array('user_email' => $data['email']));
        if ($query->num_rows() > 0)
        {
            $user_row = $query->row();
            return password_verify($data['password'], $user_row->user_password);
        }
        
        return FALSE;
    }

    // Read data from database to show data in admin page
    public function read_user_information($email) {

        $condition = "user_email =" . "'" . $email . "'";
        $this->db->select('*');
        $this->db->from('user_login');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

}

?>
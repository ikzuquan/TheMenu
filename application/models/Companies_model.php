<?php
class Companies_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

        public function get_companies($id = FALSE, $orderby = 'id')
        {
            if ($id === FALSE)
            {
                    $this->db->order_by($orderby.' ASC');
                    $query = $this->db->get('companies');
                    return $query->result_array();
            }
            $this->db->order_by($orderby.' ASC');
            $query = $this->db->get_where('companies', array('id' => $id));
            return (object) $query->row_array();
        }

        public function set_company()
        {
            $this->load->helper('url');

            $data = array(
                'company_name' => strtoupper($this->input->post('company_name')),
                'ssm_no' => strtoupper($this->input->post('ssm_no')),
                'address' => strtoupper($this->input->post('address')),
                'hotline' => strtoupper($this->input->post('hotline'))
            );

            return (object) $this->db->insert('companies', $data);
        }

        public function update_company($id)
        {
            $this->load->helper('url');

            $data = array(
                'company_name' => strtoupper($this->input->post('company_name')),
                'ssm_no' => strtoupper($this->input->post('ssm_no')),
                'address' => strtoupper($this->input->post('address')),
                'hotline' => strtoupper($this->input->post('hotline')),
                'active' => $this->input->post('active'),
                
            );

            return $this->db->update('companies', $data, ['id' => $id]);
        }
}
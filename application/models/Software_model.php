<?php
class Software_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

        public function get_softwares($id = FALSE)
        {
            if ($id === FALSE)
            {
                    $this->db->order_by('created_time DESC');
                    $query = $this->db->get('software');
                    return $query->result_array();
            }
            $this->db->order_by($orderby.' ASC');
            $query = $this->db->get_where('software', array('id' => $id));
            return (object) $query->row_array();
        }

        public function set_software($data)
        {
            $this->load->helper('url');

            return (object) $this->db->insert('software', $data);
        }
}
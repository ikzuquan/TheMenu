<?php
class Devices_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

        public function get_devices($id = FALSE, $orderby = 'id')
        {
            if ($id === FALSE)
            {
                    $this->db->order_by($orderby.' ASC');
                    $query = $this->db->get('devices');
                    return $query->result_array();
            }
            $this->db->order_by($orderby.' ASC');
            $query = $this->db->get_where('devices', array('id' => $id));
            return (object) $query->row_array();
        }

        public function set_device($data)
        {
            $this->load->helper('url');

            return (object) $this->db->insert('devices', $data);
        }

        public function update_device($id, $data)
        {
            $this->load->helper('url');

            return $this->db->update('devices', $data, ['id' => $id]);
        }
}
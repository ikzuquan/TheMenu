<?php
class Menus_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

        public function get_menus($id = FALSE, $orderby = 'id')
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

        public function get_menus_bydevice($device_id)
        {
            $query = $this->db->get_where('menus', array('device_id' => $device_id));
            return (object) $query->row_array();
        }
}
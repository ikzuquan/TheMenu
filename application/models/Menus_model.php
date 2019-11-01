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
            $query = $this->db->get_where('devices', array('id' => $id, 'active' => 1));
            return (object) $query->row_array();
        }

        public function get_menus_bydevice($device_id)
        {
            $query = $this->db->get_where('menus', array('device_id' => $device_id, 'active' => 1));
            return (object) $query->result_array();
        }

        public function get_max_order_rank($device_id)
        {
            $this->db->select_max('order_rank');
            $this->db->where('device_id', $device_id);
            $this->db->where('active', 1);
            $res1 = $this->db->get('menus');

            if ($res1->num_rows() > 0)
            {
                $res2 = $res1->result_array();
                return $res2[0]['order_rank'];
            } else {
                return 0;
            }
        }

        public function set_menus($data)
        {

            return (object) $this->db->insert('menus', $data);
        }

        public function change_menu_order($from, $to, $device_id)
        {
            
            if($this->db->update('menus', ['order_rank' => -1], ['order_rank' => $from, 'device_id' => $device_id])){
                if($from > $to){
                    $sql = "UPDATE menus set order_rank = order_rank+1 where order_rank >= $to and order_rank <$from";
                    if($this->db->query($sql)){
                        if($this->db->update('menus', ['order_rank' => $to], ['order_rank' => -1, 'device_id' => $device_id])){
                            return true;
                        } else {
                            return false;
                        }
                    }
                } else {
                    $sql = "UPDATE menus set order_rank = order_rank-1 where order_rank <= $to and order_rank >$from";
                    if($this->db->query($sql)){
                        if($this->db->update('menus', ['order_rank' => $to], ['order_rank' => -1, 'device_id' => $device_id])){
                            return true;
                        } else {
                            return false;
                        }
                    }
                }
                
            } else {
                return false;
            }
        }

        public function remove_order($order, $device_id)
        {
            $this->db->where('device_id', $device_id);
            $this ->db->where('order_rank', $order);
            $sql = "UPDATE menus set order_rank = 0, active=0 where order_rank = $order and device_id =$device_id";

            if($this->db->query($sql)){
                $sql = "UPDATE menus set order_rank = order_rank-1 where order_rank > $order";
                if($this->db->query($sql)){
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
}
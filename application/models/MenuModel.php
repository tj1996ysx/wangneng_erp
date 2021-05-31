<?php

class MenuModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function count($arr = array()) {
        $count = $this->db->count_all('system_menu');
        return $count;
    }

    public function delete($id) {
        $res = $this->db->where('id', $id)->delete('system_menu');
        return $this->db->affected_rows();
    }

    public function issetchild($id) {
        $dat = $this->db->where('parent', $id)->get('system_menu')->row_array();
        return $dat;
    }

    public function insert($data) {
        $res = $this->db->insert('system_menu', $data);
        return $res;
    }

    public function getall() {
        $res = $this->db->order_by('sort', 'desc')->get('system_menu')->result_array();
        return $res;
    }

    public function getone($id) {
        $dat = $this->db->where('id', $id)->get('system_menu')->row_array();
        return $dat;
    }

    public function update($id, $data) {

        $dat = $this->db->where('id', $id)->update('system_menu', $data);
        return $this->db->affected_rows();
    }

}

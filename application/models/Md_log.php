<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Md_log extends CI_Model
{
    public $table = 'log'; 
    public $id = 'log.id_log';

    public function __construct()
    {
        parent::__construct();
    }
    public function get()
    {
        $user_id = $this->session->userdata('id');
        $this->db->from($this->table);
        $this->db->where('id_user', $user_id); 
        $this->db->order_by('id_log', 'DESC'); 
        $this->db->limit(10);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
}
?>

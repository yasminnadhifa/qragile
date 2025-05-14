<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Md_system extends CI_Model
{
    public $table = 'system'; 
    public $id = 'system.id_system';

    public function __construct()
    {
        parent::__construct();
    }
    public function get()
    {
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getById($id)
    {
        $this->db->from($this->table);
        $this->db->where('id_system', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function getByName($data)
    {
        $this->db->from($this->table);
        $this->db->where('type', $data);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }
    public function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
        return $this->db->affected_rows();
    }
}
?>

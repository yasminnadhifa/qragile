<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Md_cat extends CI_Model
{
    public $table = 'categories'; 
    public $id = 'categories.id_cat';

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
        $this->db->where('id_cat', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function getByProject($id)
    {
        $this->db->from($this->table);
        $this->db->where('id_project', $id);
        $query = $this->db->get();
        return $query->result_array();
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

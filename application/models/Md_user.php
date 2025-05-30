<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Md_user extends CI_Model
{
    public $table = 'user'; 
    public $id = 'user.id_user';

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

    public function getByUsername($username)
    {
        $query = $this->db->get_where($this->table, ['username' => $username]);
        return $query->row_array();
    }
    public function getById($id)
    {
        $this->db->from($this->table);
        $this->db->where('id_user', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function getTotal()
    {
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function getBy()
    {
        $this->db->from($this->table);
        $this->db->where('id_user', $this->session->userdata('id'));
        $query = $this->db->get();
        return $query->row_array();
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

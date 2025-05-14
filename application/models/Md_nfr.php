<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Md_nfr extends CI_Model
{
    public $table = 'nfr';
    public $id = 'nfr.id_nfr';

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
    public function get_filtered_nfr($project_id)
    {
        $this->db->select('*');
        $this->db->from('nfr');
        $this->db->where("name NOT IN (SELECT name FROM nfr_list WHERE id_project = $project_id AND (status = 0 OR status = 1 OR status = 2))", NULL, FALSE);
        $query = $this->db->get();
    
        return $query->result_array();
    }
    
}

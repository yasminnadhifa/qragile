<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Md_project extends CI_Model
{
    public $table = 'project'; 
    public $id = 'project.id_project';

    public function __construct()
    {
        parent::__construct();
    }
    public function get()
    {
        $this->db->select('project.*, domain.type as domain, system.type as system');
        $this->db->from($this->table);
        $this->db->join('domain', 'domain.id_domain = project.domain', 'left');
        $this->db->join('system', 'system.id_system = project.system', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getById($id)
    {
        $this->db->select('project.*, domain.type as domain, system.type as system');
        $this->db->from($this->table);
        $this->db->join('domain', 'domain.id_domain = project.domain', 'left');
        $this->db->join('system', 'system.id_system = project.system', 'left');
        $this->db->where('id_project', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function getDomainSystem($id)
    {
        $this->db->from($this->table);
        $this->db->where('id_project', $id);
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
    public function update_validate_status($project_id, $status) {
        $this->db->where('id_project', $project_id);
        $this->db->update('project', ['validate' => $status]);
    }
    public function getTotal()
    {
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function getTotalVal()
    {
        $this->db->from($this->table);
        $this->db->where('validate', 1);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function getTotalUnval()
    {
        $this->db->from($this->table);
        $this->db->where('validate', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
}
?>

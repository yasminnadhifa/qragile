<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Md_nfr_decision extends CI_Model
{
    public $table = 'nfr_decision';
    public $id = 'nfr_decision.id_decision';

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
    public function getById($project_id)
    {
        $this->db->from($this->table);
        $this->db->join('nfr_list', 'nfr_list.id_nfr_list = nfr_decision.nfr', 'left');
        $this->db->where('nfr_decision.id_project', $project_id);
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
    public function getByProjectAndNfr($project_id, $nfr_id)
    {
        return $this->db->get_where('nfr_decision', ['id_project' => $project_id, 'nfr' => $nfr_id])->row_array();
    }
}

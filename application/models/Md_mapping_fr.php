<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Md_mapping_fr extends CI_Model
{
    public $table = 'mapping_fr';
    public $id = 'mapping_fr.id_mapping_fr';

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
        $this->db->where('id_project', $project_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function add_or_update($data)
    {
        $this->db->where('id_project', $data['id_project']);
        $this->db->where('id_fr', $data['id_fr']);
        $this->db->where('id_nfr', $data['id_nfr']);
        $query = $this->db->get($this->table);

        if ($query->num_rows() > 0) {
            $this->db->where('id_project', $data['id_project']);
            $this->db->where('id_fr', $data['id_fr']);
            $this->db->where('id_nfr', $data['id_nfr']);
            $this->db->update($this->table, $data);
        } else {
            $this->add($data);
        }
    }
    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }
    public function delete($id_project, $id_fr, $id_nfr) {
        $this->db->where('id_project', $id_project);
        $this->db->where('id_fr', $id_fr);
        $this->db->where('id_nfr', $id_nfr);
        $this->db->delete($this->table);
    }
    public function getNfrsByFrId($project_id, $fr_id) {
        $this->db->select('id_nfr');
        $this->db->from($this->table);
        $this->db->where('id_project', $project_id);
        $this->db->where('id_fr', $fr_id);
        $query = $this->db->get();
        return $query->result_array();
    }
}

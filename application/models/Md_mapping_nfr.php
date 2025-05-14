<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Md_mapping_nfr extends CI_Model
{
    public $table = 'mapping_nfr';
    public $id = 'mapping_nfr.id_mapping_nfr';

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
        $this->db->where('id_nfr1', $data['id_nfr1']);
        $this->db->where('id_nfr2', $data['id_nfr2']);
        $query = $this->db->get($this->table);

        if ($query->num_rows() > 0) {
            $this->db->where('id_project', $data['id_project']);
            $this->db->where('id_nfr1', $data['id_nfr1']);
            $this->db->where('id_nfr2', $data['id_nfr2']);
            $this->db->update($this->table, $data);
        } else {
            $this->add($data);
        }
    }

    public function delete($id_project, $id_nfr1, $id_nfr2)
    {
        $this->db->where('id_project', $id_project);
        $this->db->where('id_nfr1', $id_nfr1);
        $this->db->where('id_nfr2', $id_nfr2);
        $this->db->delete($this->table);
    }
    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }
}

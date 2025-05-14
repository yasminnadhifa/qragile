<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Md_val_quest extends CI_Model
{
    public $table = 'val_quest'; 
    public $id = 'val_quest.id_quest';

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
    public function get_questions_with_categories($id) {
        $this->db->select('q.id_quest, q.quest, c.name as category_name');
        $this->db->from('val_quest q');
        $this->db->join('categories c', 'q.id_cat = c.id_cat');
        $this->db->where('q.id_project', $id);
        $this->db->order_by('c.name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
}
?>

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Md_nfr_user_story extends CI_Model
{
    public $table = 'nfr_user_story';
    public $id = 'nfr_user_story.id_us_nfr';

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
        $this->db->join('fr_user_story', 'fr_user_story.id_us_fr = nfr_user_story.id_us_fr', 'left');
        $this->db->join('fr', 'fr.id_fr = fr_user_story.id_fr', 'left');
        $this->db->where('nfr_user_story.id_project', $project_id);
        $this->db->select('nfr_user_story.*, fr.*'); // Select required fields
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getProjectDetailsWithNFRNames($project_id)
    {
        $results = $this->getById($project_id);
        $nfr_ids = [];

        // Collect all NFR IDs
        foreach ($results as &$result) {
            if (!empty($result['nfr'])) {
                $nfr_ids = array_merge($nfr_ids, explode(',', $result['nfr']));
            }
        }

        // Remove duplicate NFR IDs
        $nfr_ids = array_unique($nfr_ids);

        if (!empty($nfr_ids)) {
            // Fetch NFR names for all NFR IDs
            $this->db->where_in('id_nfr', $nfr_ids);
            $nfr_query = $this->db->get('nfr');
            $nfr_names = $nfr_query->result_array();

            // Map NFR IDs to NFR names
            $nfr_name_map = [];
            foreach ($nfr_names as $nfr) {
                $nfr_name_map[$nfr['id_nfr']] = $nfr['name'];
            }

            // Replace NFR IDs with NFR names in the results
            foreach ($results as &$result) {
                if (!empty($result['nfr'])) {
                    $nfr_ids = explode(',', $result['nfr']);
                    $nfr_names = array_map(function ($id) use ($nfr_name_map) {
                        return $nfr_name_map[$id] ?? $id;
                    }, $nfr_ids);
                    $result['nfr'] = implode(',', $nfr_names); // Join names with commas or use an array as needed
                }
            }
        }

        return $results;
    }
    public function add($data)
    {
        $this->db->where('id_us_fr', $data['id_us_fr']);
        $this->db->where('nfr', $data['nfr']);
        $query = $this->db->get('nfr_user_story');

        if ($query->num_rows() > 0) {
            return false;
        } else {
            $this->db->insert('nfr_user_story', $data);
            return true;
        }
    }
    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    // Metode untuk menambahkan atau memperbarui entri di tabel nfr_user_story
    public function add_or_update($data)
    {
        $this->db->where('id_us_fr', $data['id_us_fr']);
        $query = $this->db->get('nfr_user_story');

        if ($query->num_rows() > 0) {
            $this->db->where('id_us_fr', $data['id_us_fr']);
            $this->db->update('nfr_user_story', array('nfr' => $data['nfr']));
        } else {
            if (!empty($data['nfr'])) {
                $this->db->insert('nfr_user_story', $data);
            }
        }
    }

    // Metode untuk menghapus entri dari tabel nfr_user_story
    public function delete($id_us_fr, $id_nfr,$id_project)
    {
        $this->db->where('id_us_fr', $id_us_fr);
        $this->db->where('nfr', $id_nfr);
        $this->db->where('id_project', $id_project);
        $this->db->delete('nfr_user_story');
    }
    public function getIdUsFrByFrId($fr_id)
    {
        $this->db->select('id_us_nfr');
        $this->db->from('nfr_user_story');
        $this->db->where('id_fr', $fr_id);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['id_us_fr'] ?? null;
    }
    public function delete_by_id_us_fr_and_nfr($id_us_fr, $id_nfr)
    {
        $this->db->where('id_us_fr', $id_us_fr);
        $this->db->where('id_nfr', $id_nfr);
        $this->db->delete('nfr_user_story');
    }

    public function delete_by_id_us_fr($id_us_fr)
    {
        $this->db->where('id_us_fr', $id_us_fr);
        $this->db->delete('nfr_user_story');
    }public function add_batch($data) {
        return $this->db->insert_batch('nfr_user_story', $data);
    }
    
    public function delete_batch($id_us_frs) {
        $this->db->where_in('id_us_fr', $id_us_frs);
        $this->db->delete('nfr_user_story');
    }
    public function deleteByFrId($id_us_fr)
    {
        $this->db->where('id_us_fr', $id_us_fr)
                 ->delete($this->table);
    }
    

}

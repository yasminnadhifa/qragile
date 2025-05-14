<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Md_nfrlist extends CI_Model
{
    public $table = 'nfr_list';
    public $id = 'nfr_list.id_nfr_list';

    public function __construct()
    {
        parent::__construct();
    }
    public function get($id)
    {
        $this->db->from($this->table);
        $this->db->where('id_project', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getConfirm($id)
    {
        $this->db->from($this->table);
        $this->db->where('id_project', $id);
        $this->db->where('status', 2);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getFilter($id)
    {
        $this->db->from($this->table);
        $this->db->where('id_project', $id);
        $this->db->where_in('status', array(1, 2));
        $query = $this->db->get();
        return $query->result_array();
    }   
    public function getNfr($domain_type_id, $system_type_id) {
        // Dapatkan NFR dari domain
        $this->db->select('nfr');
        $this->db->from('domain');
        $this->db->where('id_domain', $domain_type_id);
        $domain_nfrs_query = $this->db->get();
        $domain_nfrs = ($domain_nfrs_query->num_rows() > 0) ? $domain_nfrs_query->row()->nfr : '';
    
        // Dapatkan NFR dari system
        $this->db->select('nfr');
        $this->db->from('system');
        $this->db->where('id_system', $system_type_id);
        $system_nfrs_query = $this->db->get();
        $system_nfrs = ($system_nfrs_query->num_rows() > 0) ? $system_nfrs_query->row()->nfr : '';
    
        log_message('error', "Domain NFRs: $domain_nfrs, System NFRs: $system_nfrs"); // Debugging
    
        // Pastikan tidak null sebelum explode
        $domain_nfrs_array = !empty($domain_nfrs) ? explode(',', $domain_nfrs) : [];
        $system_nfrs_array = !empty($system_nfrs) ? explode(',', $system_nfrs) : [];
        $all_nfrs = array_unique(array_merge($domain_nfrs_array, $system_nfrs_array));
    
        // Dapatkan NFR dari ISO dan tipe mereka
        $this->db->select('type, nfr');
        $this->db->from('iso');
        $iso_nfrs_query = $this->db->get();
        $iso_nfrs_result = $iso_nfrs_query->result_array();
    
        $final_nfrs = [];
        $type_nfrs = [];
    
        foreach ($iso_nfrs_result as $row) {
            $type = trim($row['type']);
            $iso_nfrs = array_map('trim', explode(',', $row['nfr']));
            $type_nfrs[$type] = $iso_nfrs;
        }
    
        foreach ($all_nfrs as $nfr) {
            $found = false;
            foreach ($iso_nfrs_result as $row) {
                $type = trim($row['type']);
                $iso_nfrs = array_map('trim', explode(',', $row['nfr']));
                if (in_array(trim($nfr), $iso_nfrs)) {
                    $final_nfrs[] = trim($nfr);
                    $found = true;
                    break;
                } elseif (trim($nfr) == $type) {
                    $final_nfrs = array_merge($final_nfrs, $type_nfrs[$type]);
                    $found = true;
                    break;
                }
            }
    
            if (!$found && !in_array($nfr, $final_nfrs)) {
                $final_nfrs[] = $nfr;
            }
        }
    
        return array_unique($final_nfrs);
    }
    
    
    public function getNfrNamesByIds($nfr_ids)
    {
        $this->db->where_in('id_nfr_list', $nfr_ids);
        $query = $this->db->get('nfr_list');
        return $query->result_array();
    }
    public function getByName($name)
    {
        $this->db->where('name', $name);
        $query = $this->db->get('nfr_list'); // Replace with your actual table name
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
    public function getProjectIdByNfrId($id_nfr_list)
    {
        $this->db->select('id_project');
        $this->db->from($this->table);
        $this->db->where('id_nfr_list', $id_nfr_list);
        $query = $this->db->get();
        return $query->row()->id_project;
    }
    public function getStatus($id_nfr_list)
    {
        $this->db->select('status');
        $this->db->from($this->table);
        $this->db->where('id_nfr_list', $id_nfr_list);
        $query = $this->db->get();
        return $query->row()->status;
    }
    public function updateStatus($id_nfr_list, $status)
    {
        $this->db->set('status', $status);
        $this->db->where('id_nfr_list', $id_nfr_list);
        return $this->db->update('nfr_list');
    }
    public function update_nfr_status($project_id, $nfrs, $status) {
        if (!empty($nfrs)) {
            $this->db->set('status', $status);
            $this->db->where('id_project', $project_id);
            $this->db->where_in('name', $nfrs);
            $this->db->update('nfr_list');
        }
}
public function get_all_nfr_by_project($project_id) {
    $this->db->select('name');
    $this->db->from('nfr_list');
    $this->db->where('id_project', $project_id);
    $this->db->where_in('status', array(1, 2));

    $query = $this->db->get();
    return array_column($query->result_array(), 'name');
}
public function get_nfr_by_domain_system($domain_id, $system_id, $project_id) {
    $this->db->select('*');
    $this->db->from('nfr_list');
    $this->db->join('project', 'nfr_list.id_project = project.id_project');

    if (!is_null($domain_id)) {
        $this->db->where('project.domain', $domain_id);
    } else {
        $this->db->where('project.domain', 0);
    }

    if (!is_null($system_id)) {
        $this->db->where('project.system', $system_id);
    } else {
        $this->db->where('project.system', 0);
    }

    $this->db->where('nfr_list.id_project !=', $project_id); 
    $this->db->where('project.validate', 1);
    $this->db->where('nfr_list.status', 2);
    $query = $this->db->get();
    return $query->result_array();
}

public function updatenfr($data)
{
    $this->db->where('id_nfr', $data['id_nfr']);
    $this->db->update($this->table, array('status' => $data['status']));
}
public function delete($id)
{
    $this->db->where($this->id, $id);
    $this->db->delete($this->table);
    return $this->db->affected_rows();
}
}
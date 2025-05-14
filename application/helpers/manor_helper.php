<?php defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('grantAccessFor')) {
    function grantAccessFor($allowed_roles) {
        $CI =& get_instance();
        $user_role = $CI->session->userdata('role'); 
        
        if (!in_array($user_role, $allowed_roles)) {
            redirect('auth');
        }
    }
}

if (!function_exists('addLog')) {
    function addLog($action_type, $action_desc) {
        $CI =& get_instance();
        $CI->load->model('Md_log'); 
        
        $data = array(
            'id_user' => $CI->session->userdata('id'), 
            'action_type' => $action_type,
            'action_desc' => $action_desc,
            'timestamp' => date('Y-m-d H:i:s')
        );
        
        $CI->Md_log->add($data);
    }
}

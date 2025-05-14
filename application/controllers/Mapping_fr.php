<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mapping_fr extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Md_user', 'user');
        $this->load->model('Md_mapping_fr', 'mfr');
        $this->load->model('Md_project', 'project');
        $this->load->model('Md_nfr_user_story', 'nus');
        $this->load->model('Md_nfr_decision', 'dec');
        $this->load->model('Md_nfrlist', 'nfr_list');

    }
    //Fungsi untuk memproses mapping fr dan juga untuk menambahkan nfr decision jika terdapat perubahan 
//     public function add()
// {
//     grantAccessFor(array('Developer'));
//     $data['user_login'] = $this->user->getById($this->session->userdata('id'));
//     $data['title'] = 'Projects Detail Page';
//     $current_uri = $this->uri->uri_string();
//     $this->session->set_flashdata('current_page', $current_uri);

//     $project_id = $this->input->post('id_project');
//     $mappings = $this->input->post('mapping');
//     $existing_mappings = $this->mfr->getById($project_id);

//     $existing_map = array();
//     foreach ($existing_mappings as $mapping) {
//         $existing_map[$mapping['id_fr']][$mapping['id_nfr']] = $mapping['value'];
//     }

//     $nfr_checked = array();
//     $changed_nfrs = array();
//     foreach ($mappings as $fr_id => $nfrs) {
//         $nfr_list = array();
//         foreach ($nfrs as $nfr_id => $value) {
//             $data = array(
//                 'id_project' => $project_id,
//                 'id_fr' => $fr_id,
//                 'id_nfr' => $nfr_id,
//                 'value' => $value
//             );

//             if (isset($existing_map[$fr_id][$nfr_id])) {
//                 if ($existing_map[$fr_id][$nfr_id] != $value) {
//                     $changed_nfrs[] = array(
//                         'id_nfr' => $nfr_id
//                     );
//                 }
//             } else {
//                 if ($value == 1) {
//                     $changed_nfrs[] = array(
//                         'id_nfr' => $nfr_id
//                     );
//                 }
//             }

//             $this->mfr->add_or_update($data);
//             unset($existing_map[$fr_id][$nfr_id]);

//             if ($value == 1) {
//                 $nfr_list[] = $nfr_id;
//             }
            
//             // Perbarui status nfr_list
//             $this->updateNfrListStatus($nfr_id, $value);
//         }

//         $nfr_checked[$fr_id] = !empty($nfr_list) ? implode(',', $nfr_list) : null;
//     }

//     foreach ($nfr_checked as $fr_id => $nfr_string) {
//         $id_us_fr = $this->findIdUsFrByFrId($fr_id);

//         if ($id_us_fr) {
//             $nfr_user_story_data = array(
//                 'id_us_fr' => $id_us_fr,
//                 'nfr' => $nfr_string
//             );
//             $this->nus->add_or_update($nfr_user_story_data);
//         }
//     }

//     foreach ($existing_map as $fr_id => $nfrs) {
//         foreach ($nfrs as $nfr_id => $value) {
//             $this->mfr->delete($project_id, $fr_id, $nfr_id);
//             if (!isset($mappings[$fr_id][$nfr_id])) {
//                 $id_us_fr = $this->findIdUsFrByFrId($fr_id);

//                 if ($id_us_fr) {
//                     $remaining_nfrs = $this->mfr->getNfrsByFrId($project_id, $fr_id);

//                     if (empty($remaining_nfrs)) {
//                         $this->nus->add_or_update(array(
//                             'id_us_fr' => $id_us_fr,
//                             'nfr' => ''
//                         ));
//                     }
//                 }
//             }
//         }
//     }
//     $project = $this->project->getById($project_id);
//     if ($project && $project['validate'] == 1) {
//         foreach ($changed_nfrs as $changed_nfr) {
//             $nfr_decision_data = array(
//                 'id_project' => $project_id,
//                 'nfr' => (string) $changed_nfr['id_nfr']
//             );
//             $this->dec->add($nfr_decision_data);
//         }
//     }

//     addLog('add', $this->session->userdata('name') . ' added data mapping FRxQR');
//     $this->session->set_flashdata('message', 'Mappings saved successfully!');
//     redirect('dev/projects/analysis/' . $project_id);
// }
public function add()
{
    grantAccessFor(array('Developer'));
    $data['user_login'] = $this->user->getById($this->session->userdata('id'));
    $data['title'] = 'Projects Detail Page';
    $current_uri = $this->uri->uri_string();
    $this->session->set_flashdata('current_page', $current_uri);

    $project_id = $this->input->post('id_project');
    $mappings = $this->input->post('mapping');
    $existing_mappings = $this->mfr->getById($project_id);

    // Membuat array untuk menyimpan mapping yang ada
    $existing_map = array();
    foreach ($existing_mappings as $mapping) {
        $existing_map[$mapping['id_fr']][$mapping['id_nfr']] = $mapping['value'];
    }

    $nfr_checked = array();
    $changed_nfrs = array();

    // Proses untuk menyimpan data mapping baru
    foreach ($mappings as $fr_id => $nfrs) {
        $checked_nfrs = array();
        $unchecked_nfrs = array();

        foreach ($nfrs as $nfr_id => $value) {
            // Validasi id_fr dan id_nfr
            if (empty($fr_id) || empty($nfr_id)) {
                continue; // Lewati entri yang tidak valid
            }

            $data = array(
                'id_project' => $project_id,
                'id_fr' => $fr_id,
                'id_nfr' => $nfr_id,
                'value' => $value
            );

            if (isset($existing_map[$fr_id][$nfr_id])) {
                if ($existing_map[$fr_id][$nfr_id] != $value) {
                    $changed_nfrs[] = array('id_nfr' => $nfr_id);
                }
            } else {
                if ($value == 1) {
                    $changed_nfrs[] = array('id_nfr' => $nfr_id);
                }
            }

            // Update or insert mapping
            $this->mfr->add_or_update($data);

            if ($value == 1) {
                // Update status NFR jika sebelumnya tidak dicentang
                if (!isset($existing_map[$fr_id][$nfr_id]) || $existing_map[$fr_id][$nfr_id] != 1) {
                    $this->updateNfrListStatus($nfr_id, 1); // Set status ke 1 ketika dicentang
                }
                $checked_nfrs[] = $nfr_id;
            } else {
                // Update status NFR jika sebelumnya dicentang
                if (isset($existing_map[$fr_id][$nfr_id]) && $existing_map[$fr_id][$nfr_id] == 1) {
                    $this->updateNfrListStatus($nfr_id, 0); // Set status ke 0 ketika tidak dicentang
                }
                $unchecked_nfrs[] = $nfr_id;
            }
        }

        // Update tabel nus untuk NFR yang dicentang
        $id_us_fr = $this->findIdUsFrByFrId($fr_id);

        if ($id_us_fr) {
            // Hapus entri lama
            $this->nus->deleteByFrId($id_us_fr);

            // Insert data ke tabel nus jika valid
            foreach ($checked_nfrs as $nfr_id) {
                if (!empty($nfr_id) && is_numeric($nfr_id)) {
                    $nfr_user_story_data = array(
                        'id_us_fr' => $id_us_fr,
                        'nfr' => $nfr_id,
                        'id_project' => $project_id
                    );

                    // Insert data ke tabel nus hanya jika valid
                    if (!empty($nfr_user_story_data['id_us_fr']) && !empty($nfr_user_story_data['nfr']) && !empty($nfr_user_story_data['id_project'])) {
                        $this->nus->add($nfr_user_story_data);
                    }
                }
            }

            // Hapus NFR yang tidak dicentang
            foreach ($unchecked_nfrs as $nfr_id) {
                $this->nus->delete($id_us_fr, $nfr_id, $project_id);
            }
        }
    }

    // Hapus mapping lama yang tidak ada dalam data baru
    foreach ($existing_map as $fr_id => $nfrs) {
        foreach ($nfrs as $nfr_id => $value) {
            if (!isset($mappings[$fr_id][$nfr_id])) {
                $this->mfr->delete($project_id, $fr_id, $nfr_id);
                $id_us_fr = $this->findIdUsFrByFrId($fr_id);

                if ($id_us_fr) {
                    $this->nus->delete($id_us_fr, $nfr_id, $project_id);
                }

                // Hanya set status ke 0 untuk NFR yang sebelumnya dicentang
                if ($value == 1) {
                    $this->updateNfrListStatus($nfr_id, 0); // Set status ke 0 untuk NFR yang dihapus
                }
            }
        }
    }

    $project = $this->project->getById($project_id);
    if ($project && $project['validate'] == 1) {
        foreach ($changed_nfrs as $changed_nfr) {
            // Cek jika NFR sudah ada di tabel keputusan
            $existing_decision = $this->dec->getByProjectAndNfr($project_id, $changed_nfr['id_nfr']);

            // Jika belum ada, tambahkan data keputusan NFR
            if (!$existing_decision) {
                $nfr_decision_data = array(
                    'id_project' => $project_id,
                    'nfr' => (string) $changed_nfr['id_nfr']
                );
                $this->dec->add($nfr_decision_data);
            }
        }
    }

    addLog('add', $this->session->userdata('name') . ' added data mapping FRxQR');
    $this->session->set_flashdata('message', 'Mappings saved successfully!');
    redirect('dev/projects/analysis/' . $project_id);
}




private function updateNfrListStatus($nfr_id, $status)
{
    $this->nfr_list->updateStatus($nfr_id, $status);
}

private function findIdUsFrByFrId($fr_id)
{
    $query = $this->db->get_where('fr_user_story', array('id_fr' => $fr_id));
    $result = $query->row_array();
    return $result['id_us_fr'] ?? null;
}

}

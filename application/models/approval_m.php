<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Approval_m extends CI_Model{
    
    function edit_ba($no_ba) {
        $this->db->where('no_ba', $no_ba)->update('ba', $_POST);
    }
    
    function getAllApp() {
        $this->db->select('*');
        $this->db->from('ba');
        $this->db->from('ba_caused');
        $this->db->from('ba_action');
        $this->db->from('project');
        $this->db->where('ba.id_caused = ba_caused.id_caused');
        $this->db->where('ba.id_action = ba_action.id_action');
        $this->db->where('ba.id_project = project.id_project');
        $this->db->order_by('ba.id_ba', 'desc');

        $query = $this->db->get();
        return $query;
    }
    
    function getApp() {
        $user = $this->session->userdata('username');
        $l0 = $this->login_m->dataPengguna($user);

        $this->db->select('*');
        $this->db->from('ba');
        $this->db->from('ba_caused');
        $this->db->from('ba_action');
        $this->db->from('project');
        $this->db->where('ba.id_caused = ba_caused.id_caused');
        $this->db->where('ba.id_action = ba_action.id_action');
        $this->db->where('ba.id_project = project.id_project');
        $this->db->where('ba.id_project = "'. $l0->id_project.'"');
        $this->db->order_by('ba.id_ba', 'desc');

        $query = $this->db->get();
        return $query;
    }
    
    function getAppL1() {
        $user = $this->session->userdata('username');
        $l1 = $this->login_m->dataPengguna($user);

        $this->db->select('*');
        $this->db->from('ba');
        $this->db->where('user_l1 = "'. $l1->id_user.'"');
        $this->db->where('status_l1 = "PENDING"');
        $this->db->where('status_ba = "OPEN"');
        $this->db->order_by('id_ba', 'desc');

        $query = $this->db->get();
        return $query;
    }
    
    function getAppL2() {
        $user = $this->session->userdata('username');
        $l2 = $this->login_m->dataPengguna($user);

        $this->db->select('*');
        $this->db->from('ba');
        $this->db->where('user_l2 = "'. $l2->id_user.'"');
        $this->db->where('status_l2 = "PENDING"');
        $this->db->where('status_l1 = "APPROVED"');
        $this->db->where('status_ba = "OPEN"');
        $this->db->order_by('id_ba', 'desc');

        $query = $this->db->get();
        return $query;
    }
    
    function getAppL3() {
        $user = $this->session->userdata('username');
        $l3 = $this->login_m->dataPengguna($user);

        $this->db->select('*');
        $this->db->from('ba');
        $this->db->where('user_l3 = "'. $l3->id_user.'"');
        $this->db->where('status_l3 = "PENDING"');
        $this->db->where('status_l2 = "APPROVED"');
        $this->db->where('status_ba = "OPEN"');
        $this->db->order_by('id_ba', 'desc');

        $query = $this->db->get();
        return $query;
    }

    function getAppLgm() {
        $user = $this->session->userdata('username');
        $lgm = $this->login_m->dataPengguna($user);

        $this->db->select('*');
        $this->db->from('ba');
        $this->db->where('user_lgm = "'. $lgm->id_user.'"');
        $this->db->where('status_lgm = "PENDING"');
        $this->db->where('status_l3 = "APPROVED"');
        $this->db->where('status_ba = "OPEN"');
        $this->db->order_by('id_ba', 'desc');

        $query = $this->db->get();
        return $query;
    }

    function getAppLpl() {
        $user = $this->session->userdata('username');
        $lpl = $this->login_m->dataPengguna($user);

        $this->db->select('*');
        $this->db->from('ba');
        $this->db->where('user_lpl = "'. $lpl->id_user.'"');
        $this->db->where('status_lpl = "PENDING"');
        $this->db->where('status_lgm = "APPROVED"');
        $this->db->where('status_ba = "OPEN"');
        $this->db->order_by('id_ba', 'desc');

        $query = $this->db->get();
        return $query;
    }

    function getAppLod() {
        $user = $this->session->userdata('username');
        $lod = $this->login_m->dataPengguna($user);

        $this->db->select('*');
        $this->db->from('ba');
        $this->db->where('user_lod = "'. $lod->id_user.'"');
        $this->db->where('status_lod = "PENDING"');
        $this->db->where('status_lpl = "APPROVED"');
        $this->db->where('status_ba = "OPEN"');
        $this->db->order_by('id_ba', 'desc');

        $query = $this->db->get();
        return $query;
    }

    function getAppLpd() {
        $user = $this->session->userdata('username');
        $lpd = $this->login_m->dataPengguna($user);

        $this->db->select('*');
        $this->db->from('ba');
        $this->db->where('user_lpd = "'. $lpd->id_user.'"');
        $this->db->where('status_lpd = "PENDING"');
        $this->db->where('status_lod = "APPROVED"');
        $this->db->where('status_ba = "OPEN"');
        $this->db->order_by('id_ba', 'desc');

        $query = $this->db->get();
        return $query;
    }

    private function applyApprovalScope($pengguna) {
        if ($pengguna->kode_project == '000H') {
            return;
        }

        $uid = (int) $pengguna->id_user;
        switch ($pengguna->sign) {
            case 'L1':
                $this->db->where('ba.user_l1', $uid);
                $this->db->where('ba.status_l1', 'PENDING');
                $this->db->where('ba.status_ba', 'OPEN');
                break;
            case 'L2':
                $this->db->where('ba.user_l2', $uid);
                $this->db->where('ba.status_l2', 'PENDING');
                $this->db->where('ba.status_l1', 'APPROVED');
                $this->db->where('ba.status_ba', 'OPEN');
                break;
            case 'L3':
                $this->db->where('ba.user_l3', $uid);
                $this->db->where('ba.status_l3', 'PENDING');
                $this->db->where('ba.status_l2', 'APPROVED');
                $this->db->where('ba.status_ba', 'OPEN');
                break;
            case 'LGM':
                $this->db->where('ba.user_lgm', $uid);
                $this->db->where('ba.status_lgm', 'PENDING');
                $this->db->where('ba.status_l3', 'APPROVED');
                $this->db->where('ba.status_ba', 'OPEN');
                break;
            case 'LPL':
                $this->db->where('ba.user_lpl', $uid);
                $this->db->where('ba.status_lpl', 'PENDING');
                $this->db->where('ba.status_lgm', 'APPROVED');
                $this->db->where('ba.status_ba', 'OPEN');
                break;
            case 'LOD':
                $this->db->where('ba.user_lod', $uid);
                $this->db->where('ba.status_lod', 'PENDING');
                $this->db->where('ba.status_lpl', 'APPROVED');
                $this->db->where('ba.status_ba', 'OPEN');
                break;
            case 'LPD':
                $this->db->where('ba.user_lpd', $uid);
                $this->db->where('ba.status_lpd', 'PENDING');
                $this->db->where('ba.status_lod', 'APPROVED');
                $this->db->where('ba.status_ba', 'OPEN');
                break;
            default:
                $this->db->where('ba.id_project', (int) $pengguna->id_project);
                break;
        }
    }

    private function buildApprovalListQuery($pengguna, $search = '') {
        $unit_remove_sql = "(SELECT u.unit_no FROM kanibal k
            LEFT JOIN unit u ON k.id_unit = u.id_unit
            WHERE k.no_ba = ba.no_ba AND k.type = 'REMOVE'
            ORDER BY k.id_kanibal DESC LIMIT 1)";
        $unit_install_sql = "(SELECT u.unit_no FROM kanibal k
            LEFT JOIN unit u ON k.id_unit = u.id_unit
            WHERE k.no_ba = ba.no_ba AND k.type = 'INSTALL'
            ORDER BY k.id_kanibal DESC LIMIT 1)";

        $this->db->from('ba');
        $this->db->select("ba.id_ba, ba.no_ba, ba.posting_date,
            ba.status_l1, ba.status_l2, ba.status_l3,
            ba.status_lgm, ba.status_lpl, ba.status_lod, ba.status_lpd,
            {$unit_remove_sql} AS unit_remove,
            {$unit_install_sql} AS unit_install", false);
        $this->applyApprovalScope($pengguna);

        if ($search !== '') {
            $esc = $this->db->escape_like_str($search);
            $this->db->where("(ba.no_ba LIKE '%{$esc}%'
                OR ba.posting_date LIKE '%{$esc}%'
                OR ba.status_l1 LIKE '%{$esc}%'
                OR ba.status_l2 LIKE '%{$esc}%'
                OR ba.status_l3 LIKE '%{$esc}%'
                OR ba.status_lpl LIKE '%{$esc}%'
                OR ba.status_lgm LIKE '%{$esc}%'
                OR ba.status_lod LIKE '%{$esc}%'
                OR ba.status_lpd LIKE '%{$esc}%'
                OR {$unit_remove_sql} LIKE '%{$esc}%'
                OR {$unit_install_sql} LIKE '%{$esc}%')", null, false);
        }
    }

    function countApprovalList($pengguna, $search = '') {
        $this->buildApprovalListQuery($pengguna, $search);
        return (int) $this->db->count_all_results();
    }

    function getApprovalListPage($pengguna, $search, $start, $length, $order_col, $order_dir) {
        $columns = array(
            'ba.id_ba',
            'ba.no_ba',
            'unit_remove',
            'unit_install',
            'ba.posting_date',
            'ba.status_l1',
            'ba.status_l2',
            'ba.status_l3',
            'ba.status_lgm',
            'ba.status_lpl',
            'ba.status_lod',
            'ba.status_lpd',
            'ba.id_ba'
        );
        $order_by = isset($columns[$order_col]) ? $columns[$order_col] : 'ba.id_ba';
        $order_dir = strtolower($order_dir) === 'asc' ? 'asc' : 'desc';

        $this->buildApprovalListQuery($pengguna, $search);
        $this->db->order_by($order_by, $order_dir);
        if ($length > 0) {
            $this->db->limit($length, $start);
        }
        return $this->db->get()->result();
    }
    
    function getDetailBa($no_ba) {
        $this->db->select('*');
        $this->db->from('ba');
        $this->db->join('ba_action a','ba.id_action = a.id_action','left');
        $this->db->join('ba_status s','ba.id_status = s.id_status','left');
        $this->db->join('ba_caused c','ba.id_caused = c.id_caused','left');
        $this->db->join('project p','ba.id_project = p.id_project','left');
        $this->db->where(array('ba.no_ba'=> $no_ba));
        $no_ba = $this->db->get()->row();
        return $no_ba;
    }
    
    function getDetailRemove($no_ba) {
        $this->db->select('*');
        $this->db->from('kanibal k');
        $this->db->join('replacement r','k.id_rep = r.id_rep','left');
        $this->db->join('unit u','k.id_unit = u.id_unit','left');
        $this->db->where(array('k.no_ba'=> $no_ba));
        $this->db->where('k.type','REMOVE');
        $no_ba = $this->db->get()->row();
        return $no_ba;
    }
    
    function getDetailInstall($no_ba) {
        $this->db->select('*');
        $this->db->from('kanibal k');
        $this->db->join('replacement r','k.id_rep = r.id_rep','left');
        $this->db->join('unit u','k.id_unit = u.id_unit','left');
        $this->db->where(array('k.no_ba'=> $no_ba));
        $this->db->where('k.type','INSTALL');
        $no_ba = $this->db->get()->row();
        return $no_ba;
    }
    
    function getUserL1($no_ba) {
        $this->db->select('*');
        $this->db->from('ba');
        $this->db->join('user u1','ba.user_l1 = u1.id_user','left');
        $this->db->where(array('ba.no_ba'=> $no_ba));
        $no_ba = $this->db->get()->row();
        return $no_ba;
    }
    
    function getUserL2($no_ba) {
        $this->db->select('*');
        $this->db->from('ba');
        $this->db->join('user u2','ba.user_l2 = u2.id_user','left');
        $this->db->where(array('ba.no_ba'=> $no_ba));
        $no_ba = $this->db->get()->row();
        return $no_ba;
    }
    
    function getUserL3($no_ba) {
        $this->db->select('*');
        $this->db->from('ba');
        $this->db->join('user u3','ba.user_l3 = u3.id_user','left');
        $this->db->where(array('ba.no_ba'=> $no_ba));
        $no_ba = $this->db->get()->row();
        return $no_ba;
    }

    function getUserLpl($no_ba) {
        $this->db->select('*');
        $this->db->from('ba');
        $this->db->join('user u','ba.user_lpl = u.id_user','left');
        $this->db->where(array('ba.no_ba'=> $no_ba));
        return $this->db->get()->row();
    }

    function getUserLgm($no_ba) {
        $this->db->select('*');
        $this->db->from('ba');
        $this->db->join('user u','ba.user_lgm = u.id_user','left');
        $this->db->where(array('ba.no_ba'=> $no_ba));
        return $this->db->get()->row();
    }

    function getUserLod($no_ba) {
        $this->db->select('*');
        $this->db->from('ba');
        $this->db->join('user u','ba.user_lod = u.id_user','left');
        $this->db->where(array('ba.no_ba'=> $no_ba));
        return $this->db->get()->row();
    }

    function getUserLpd($no_ba) {
        $this->db->select('*');
        $this->db->from('ba');
        $this->db->join('user u','ba.user_lpd = u.id_user','left');
        $this->db->where(array('ba.no_ba'=> $no_ba));
        return $this->db->get()->row();
    }
    
    function select_optl1($no_ba) {
        $this->db->select('status_l1');
        $this->db->from('ba');
        $this->db->where(array('no_ba'=> $no_ba));
        $no_ba = $this->db->get()->row_array();
        return $no_ba;
    }
    
    function select_optl2($no_ba) {
        $this->db->select('status_l2');
        $this->db->from('ba');
        $this->db->where(array('no_ba'=> $no_ba));
        $no_ba = $this->db->get()->row_array();
        return $no_ba;
    }
    
    function select_optl3($no_ba) {
        $this->db->select('status_l3');
        $this->db->from('ba');
        $this->db->where(array('no_ba'=> $no_ba));
        $no_ba = $this->db->get()->row_array();
        return $no_ba;
    }

    function select_optlpl($no_ba) {
        $this->db->select('status_lpl');
        $this->db->from('ba');
        $this->db->where(array('no_ba'=> $no_ba));
        return $this->db->get()->row_array();
    }

    function select_optlgm($no_ba) {
        $this->db->select('status_lgm');
        $this->db->from('ba');
        $this->db->where(array('no_ba'=> $no_ba));
        return $this->db->get()->row_array();
    }

    function select_optlod($no_ba) {
        $this->db->select('status_lod');
        $this->db->from('ba');
        $this->db->where(array('no_ba'=> $no_ba));
        return $this->db->get()->row_array();
    }

    function select_optlpd($no_ba) {
        $this->db->select('status_lpd');
        $this->db->from('ba');
        $this->db->where(array('no_ba'=> $no_ba));
        return $this->db->get()->row_array();
    }

    function caused() {
        return $this->db->get('ba_caused')->result();
    }
    
    function status() {
        return $this->db->get('ba_status')->result();
    }
    
    function action() {
        return $this->db->get('ba_action')->result();
    }
}
?>

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

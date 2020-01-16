<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Cannibal_m extends CI_Model{
    
    function selectAll() {
        return $this->db->query(
                    'SELECT DISTINCT * 
                    FROM ba 
                    LEFT JOIN ba_caused ON ba.id_caused = ba_caused.id_caused
                    LEFT JOIN ba_action ON ba.id_action = ba_action.id_action
                    LEFT JOIN project ON ba.id_project = project.id_project
                    ORDER BY ba.id_ba DESC'
                )->result();
    }
    
    function selectPMNotApproved() {
        return $this->db->query(
                    'SELECT DISTINCT * 
                    FROM ba 
                    LEFT JOIN ba_caused ON ba.id_caused = ba_caused.id_caused
                    LEFT JOIN ba_action ON ba.id_action = ba_action.id_action
                    LEFT JOIN project ON ba.id_project = project.id_project
                    WHERE ba.status_l3 = "PENDING" AND ba.status_l1 != "NOT APPROVED" AND ba.status_l2 != "NOT APPROVED"
                    ORDER BY ba.id_ba DESC'
                );
    }
    
    function selectAllByProject() {
            
        $user = $this->session->userdata('username');
        $pengguna = $this->login_m->dataPengguna($user);

        $this->db->select('*');
        $this->db->from('ba');
        $this->db->from('ba_caused');
        $this->db->from('ba_action');
        $this->db->from('project');
        $this->db->where('ba.id_caused = ba_caused.id_caused');
        $this->db->where('ba.id_action = ba_action.id_action');
        $this->db->where('ba.id_project = project.id_project');
        $this->db->where('ba.id_project = "'. $pengguna->id_project.'"');
        $this->db->order_by('ba.id_ba', 'desc');

        $query = $this->db->get();
        return $query->result();
    }
    
    function insert($set) {
        $this->db->insert('ba', $set);
    }
    
    function delete($id) {
        $table = array('ba');
        $this->db->where('id_ba',$id);
        $this->db->delete($table);
    }
    
    function edit_ba($id) {
        $this->db->where('id_ba', $id)->update('ba', $_POST);
    }
    
    function edit_kanibal($id) {
        $this->db->where('id_kanibal', $id)->update('kanibal', $_POST);
    }
    
    function select($id) {
        $this->db->select('*');
        $this->db->from('unit, model, project, commod, comp');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $this->db->where(array('unit.id_unit'=> $id));
        $id = $this->db->get()->row();
        return $id;
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
    
    function getIdBa() {
        return $this->db->get('ba')->num_rows();
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
    
    function getDetail($id_kanibal) {
        $this->db->select('*');
        $this->db->from('kanibal k');
        $this->db->join('replacement r','k.id_rep = r.id_rep','left');
        $this->db->join('unit u','k.id_unit = u.id_unit','left');
        $this->db->where(array('k.id_kanibal'=> $id_kanibal));
        $id_ba = $this->db->get()->row();
        return $id_ba;
    }
    
    function getUnit() {
        $this->db->select('*');
        $this->db->from('unit');
        $this->db->from('project');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->order_by('unit.unit_no', 'asc');

        $query = $this->db->get();
        return $query->result_array();
    }
    
    function getUnitByProject() {
        $user = $this->session->userdata('username');
        $pengguna = $this->login_m->dataPengguna($user);

        $this->db->select('*');
        $this->db->from('unit');
        $this->db->from('project');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('unit.id_project = "'. $pengguna->id_project.'"');
        $this->db->order_by('unit.unit_no', 'asc');

        $query = $this->db->get();
        return $query->result_array();
    }
    
    function getProject() {
        $result = $this->db->query('select * from project order by kode_project asc');
        if ($result->num_rows() > 0){
            return $result->result_array();            
        } else{
            return array();
        }
    }
    
    function getKodeProject($id) {
        $result = $this->db->query('select * from project where id_project = '.$id.' order by kode_project asc');
        if ($result->num_rows() > 0){
            return $result->row();            
        } else{
            return array();
        }
    }
    
    
    function getReplacement() {
        $this->db->select("*");
        $this->db->from("replacement r");
        $this->db->join("unit u","r.id_unit = u.id_unit","left");
        $this->db->join("commod m","r.id_mod = m.id_mod","left");
        $this->db->join("comp c","m.id_comp = c.id_comp","left");
        $this->db->join("project p","u.id_project = p.id_project","left");
        $this->db->where("wo_status = 'OPEN'");
        $this->db->where("wo_no != 0");
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function select_project($id) {
        $this->db->select('id_project');
        $this->db->from('ba');
        $this->db->where(array('id_ba'=> $id));
        $id = $this->db->get()->row_array();
        return $id;
    }
    
    function select_unit($id) {
        $this->db->select('id_unit');
        $this->db->from('kanibal');
        $this->db->where(array('id_kanibal'=> $id));
        $id = $this->db->get()->row_array();
        return $id;
    }
    
    function select_rep($id) {
        $this->db->select('id_rep');
        $this->db->from('kanibal');
        $this->db->where(array('id_kanibal'=> $id));
        $id = $this->db->get()->row_array();
        return $id;
    }
    
    function get_l1($id) {
        $this->db->select('id_user');
        $this->db->from('user');
        $this->db->join('project','user.id_project = project.id_project','left');
        $this->db->where("sign = 'L1'");
        $this->db->where(array('user.id_project' => $id));
        $id = $this->db->get()->row();
        return $id;
    }
    
    function get_l2($id) {
        $this->db->select('id_user');
        $this->db->from('user');
        $this->db->join('project','user.id_project = project.id_project','left');
        $this->db->where("sign = 'L2'");
        $this->db->where(array('user.id_project' => $id));
        $id = $this->db->get()->row();
        return $id;
    }
    
    function get_l3($id) {
        $this->db->select('id_user');
        $this->db->from('user');
        $this->db->join('project','user.id_project = project.id_project','left');
        $this->db->where("sign = 'L3'");
        $this->db->where(array('user.id_project' => $id));
        $id = $this->db->get()->row();
        return $id;
    }
    
    function generateAutoid($id){ 
             
    $query=$this->db->query("select count(id_ba) as id from ba where id_project = $id");
    $result = $query->row_array();
    $num = $result['id']+1;
            switch (strlen($num)){   
            case 1 : $no_ba = "00".$num; break;      
            case 2 : $no_ba = "0".$num; break;      
            default: $no_ba = $num;    
                }
            return $no_ba; 
   }
}
?>

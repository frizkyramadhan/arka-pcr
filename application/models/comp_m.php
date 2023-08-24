<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Comp_m extends CI_Model{
    
    function selectAll() {
        return $this->db->get('comp')->result();
    }
    
    function insert($set) {
        $this->db->insert('comp', $set);
    }
    
    function delete($id) {
        $this->db->where('id_comp', $id);
        $this->db->delete('comp');
    }
    
    function update($id) {
        $this->db->where('id_comp', $id)->update('comp', $_POST);
    }
    
    function select($id) {
        return $this->db->get_where('comp', array('id_comp'=>$id))->row();
    }
    
    function select_type($id) {
        $this->db->select('comp_type');
        $this->db->from('comp');
        $this->db->where(array('id_comp'=> $id));
        $id = $this->db->get()->row_array();
        return $id;
    }
    
    function select_status($id) {
        $this->db->select('status');
        $this->db->from('comp');
        $this->db->where(array('id_comp'=> $id));
        $id = $this->db->get()->row_array();
        return $id;
    }

    
}

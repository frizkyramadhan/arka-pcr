<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_m extends CI_Model{
    
    function selectAll() {
        return $this->db->query('SELECT * FROM model')->result();
    }
    
    function insert($set) {
        $this->db->insert('model', $set);
    }
    
    function insert_mod($set) {
        $this->db->insert('commod', $set);
    }
    
    function delete($id) {
        $table = array('model','commod');
        $this->db->where('id_model',$id);
        $this->db->delete($table);
    }
    
    function del_mod($id) {
        $this->db->where('id_mod', $id);
        $this->db->delete('commod');
    }
    
    function update($id) {
        $this->db->where('id_model', $id)->update('model', $_POST);
    }
    
    function update_mod($id) {
        $this->db->where('id_mod', $id)->update('commod', $_POST);
    }
    
    function select($id) {
        return $this->db->get_where('model', array('id_model'=>$id))->row();
    }
    
    function select_model($id) {
        $this->db->select('*');
        $this->db->from('commod, model, comp');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $this->db->where(array('commod.id_mod'=> $id));
        $id = $this->db->get()->row();
        return $id;
    }
    
    function select_mod($id) {
        $this->db->select('*');
        $this->db->from('commod, model, comp');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $this->db->where(array('commod.id_model'=> $id));
        $id = $this->db->get()->result();
        return $id;
    }
    
    function select_desc($id) {
        $this->db->select('description');
        $this->db->from('model');
        $this->db->where(array('id_model'=> $id));
        $id = $this->db->get()->row_array();
        return $id;
    }
    
    function select_comp($id) {
        $this->db->select('id_comp');
        $this->db->from('commod');
        $this->db->where(array('id_mod'=> $id));
        $id = $this->db->get()->row_array();
        return $id;
    }
    
    }
?>

<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Project_m extends CI_Model{
    
    function selectAll() {
        return $this->db->get('project')->result();
    }
    
    function insert($set) {
        $this->db->insert('project', $set);
    }
    
    function delete($id) {
        $this->db->where('id_project', $id);
        $this->db->delete('project');
    }
    
    function update($id) {
        $this->db->where('id_project', $id)->update('project', $_POST);
    }
    
    function select($id) {
        return $this->db->get_where('project', array('id_project'=>$id))->row();
    }

    
}
?>

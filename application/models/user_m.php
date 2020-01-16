<?php

class User_m extends CI_Model {

    function selectAll() {
        return $this->db->query('select * from user join project on user.id_project = project.id_project')->result();
    }
    
    function insert($set) {
        $this->db->insert('user', $set);
    }
    
    function delete($id) {
        $this->db->where('id_user', $id);
        $this->db->delete('user');
    }
    
    function update($id) {
        $this->db->where('id_user', $id)->update('user', $_POST);
    }
    
    function select($id) {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->from('project');
        $this->db->where('user.id_project = project.id_project');
        $this->db->where(array('id_user'=> $id));
        $id = $this->db->get()->row();
        return $id;
    }
    
    function select_level($id) {
        $this->db->select('level');
        $this->db->from('user');
        $this->db->where(array('id_user'=> $id));
        $id = $this->db->get()->row_array();
        return $id;
    }
    
    function select_project($id) {
        $this->db->select('id_project');
        $this->db->from('user');
        $this->db->where(array('id_user'=> $id));
        $id = $this->db->get()->row_array();
        return $id;
    }
    
    function select_sign($id) {
        $this->db->select('sign');
        $this->db->from('user');
        $this->db->where(array('id_user'=> $id));
        $id = $this->db->get()->row_array();
        return $id;
    }
}
?>

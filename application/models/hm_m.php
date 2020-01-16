<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Hm_m extends CI_Model{
    
    function get_hm($limit, $start, $st = NULL)
    {
        if ($st == "NIL") $st = "";
        $sql = "select * from hm join unit on hm.id_unit = unit.id_unit 
            where unit_no like '%$st%' or hm_unit like '%$st%' or wh_day like '%$st%' or date_hm like '%$st%' order by date_hm desc
                limit " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    function get_hm_count($st = NULL)
    {
        if ($st == "NIL") $st = "";
        $sql = "select * from hm join unit on hm.id_unit = unit.id_unit 
            where unit_no like '%$st%' or hm_unit like '%$st%' or wh_day like '%$st%' or date_hm like '%$st%'";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }    
    
    function insert($set) {
        $this->db->insert('hm', $set);
    }
    
    function delete($id) {
        $this->db->where('id_hm', $id);
        $this->db->delete('hm');
    }
    
    function update($id) {
        $this->db->where('id_hm', $id)->update('hm', $_POST);
    }
    
    function select($id) {
        return $this->db->get_where('hm', array('id_hm'=>$id))->row();
    }
    
    function select_unit($id) {
        $this->db->select('id_unit');
        $this->db->from('hm');
        $this->db->where(array('id_hm'=> $id));
        $id = $this->db->get()->row_array();
        return $id;
    }
}
?>

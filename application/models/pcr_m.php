<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Pcr_m extends CI_Model{
    
    function getProject() {
        $result = $this->db->get('project');
        if ($result->num_rows() > 0){
            return $result->result_array();            
        } else{
            return array();
        }
    }
    
    function getUnitByProject($id_project) {
        $this->db->select('*');
        $this->db->from('unit');
        $this->db->where('id_project',$id_project);        
        $result = $this->db->get();
        if ($result->num_rows() > 0){
            return $result->result_array();            
        } else{
            return array();
        }
    }
    
    function getWoStatus($id_unit) {
        $this->db->distinct('wo_status');
        $this->db->from('replacement');
        $this->db->where('id_unit',$id_unit);        
        $this->db->order_by('wo_status','asc');        
        $result = $this->db->get();
        if ($result->num_rows() > 0){
            return $result->result_array();            
        } else{
            return array();
        }
    }
    
    function selectAll() {
        $this->db->select('*');
        $this->db->from('replacement, unit, model, project, commod, comp');
        $this->db->where('replacement.id_unit = unit.id_unit');
        $this->db->where('replacement.id_mod = commod.id_mod');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $this->db->order_by('project.kode_project', 'asc');
        $this->db->order_by('model.manufacture', 'asc');
        $this->db->order_by('comp.comp_desc', 'asc');
        $this->db->order_by('replacement.id_rep', 'desc');
        $id = $this->db->get()->result();
        return $id;
    }
    
    function selectAllByProject($id_project) {
            
        $this->db->select('*');
        $this->db->from('replacement, unit, model, project, commod, comp');
        $this->db->where('replacement.id_unit = unit.id_unit');
        $this->db->where('replacement.id_mod = commod.id_mod');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $this->db->where('unit.id_project = "'. $id_project.'"');
        $this->db->order_by('project.kode_project', 'asc');
        $this->db->order_by('model.manufacture', 'asc');
        $this->db->order_by('model.model_no', 'asc');
        $this->db->order_by('unit.unit_no', 'asc');
        $this->db->order_by('comp.comp_desc', 'asc');
        $this->db->order_by('replacement.id_rep', 'desc');

        $query = $this->db->get();
        return $query->result();
    }
    
    function selectAllByProjectAndUnit($id_project,$id_unit) {
            
        $this->db->select('*');
        $this->db->from('replacement, unit, model, project, commod, comp');
        $this->db->where('replacement.id_unit = unit.id_unit');
        $this->db->where('replacement.id_mod = commod.id_mod');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $this->db->where('unit.id_project = "'. $id_project.'"');
        $this->db->where('unit.id_unit = "'. $id_unit.'"');
        $this->db->order_by('project.kode_project', 'asc');
        $this->db->order_by('model.manufacture', 'asc');
        $this->db->order_by('comp.comp_desc', 'asc');
        $this->db->order_by('unit.unit_no', 'desc');
        $this->db->order_by('replacement.id_rep', 'desc');

        $query = $this->db->get();
        return $query->result();
    }
}
?>

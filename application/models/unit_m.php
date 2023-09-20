<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Unit_m extends CI_Model
{

    //    function selectAll() {
    //        return $this->db->query(
    //                    'SELECT * 
    //                    FROM unit 
    //                    LEFT JOIN model ON unit.id_model = model.id_model 
    //                    LEFT JOIN project ON unit.id_project = project.id_project 
    //                    ORDER BY unit.unit_no ASC'
    //                )->result();
    //    }

    function get_unit($limit, $start, $st = NULL)
    {
        if ($st == "NIL") $st = "";
        $sql = "SELECT * 
                    FROM unit 
                    LEFT JOIN model ON unit.id_model = model.id_model 
                    LEFT JOIN project ON unit.id_project = project.id_project 
                    where unit_no like '%$st%' or unit_desc like '%$st%' or model_no like '%$st%' or kode_project like '%$st%' ORDER BY unit.unit_no ASC
                    limit " . $start . ", " . $limit;
        $query = $this->db->query($sql);
        return $query->result();
    }

    function selectAllByProject($limit, $start, $st = NULL)
    {
        $user = $this->session->userdata('username');
        $pengguna = $this->login_m->dataPengguna($user);
        if ($st == "NIL") $st = "";
        $sql = "SELECT * 
                    FROM unit 
                    LEFT JOIN model ON unit.id_model = model.id_model 
                    LEFT JOIN project ON unit.id_project = project.id_project 
                    where unit.id_project = '$pengguna->id_project'
                    and (unit_no like '%$st%' or unit_desc like '%$st%' or model_no like '%$st%' or kode_project like '%$st%')
                    ORDER BY unit.unit_no ASC
                    limit " . $start . ", " . $limit;
        $query = $this->db->query($sql);

        return $query->result();
    }

    function searchUnit($st = NULL)
    {
        if ($st == "NIL") $st = "";
        $sql = "SELECT * 
        FROM unit 
        LEFT JOIN model ON unit.id_model = model.id_model 
        LEFT JOIN project ON unit.id_project = project.id_project 
        where unit_no like '%$st%' or unit_desc like '%$st%' or model_no like '%$st%' or kode_project like '%$st%' ORDER BY unit.unit_no ASC";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    function searchUnitByProject($st = NULL)
    {
        $user = $this->session->userdata('username');
        $pengguna = $this->login_m->dataPengguna($user);
        if ($st == "NIL") $st = "";

        $this->db->select('*');
        $this->db->from('unit');
        $this->db->from('model');
        $this->db->from('project');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('unit.id_project = "' . $pengguna->id_project . '"');
        $this->db->like('unit.unit_no', $st);
        $this->db->like('unit.unit_desc', $st);
        $this->db->like('model.model_no', $st);
        $this->db->like('project.kode_project', $st);
        $this->db->order_by('unit.unit_no', 'asc');

        $query = $this->db->get();
        return $query->num_rows();
    }

    function countByProject()
    {
        $user = $this->session->userdata('username');
        $pengguna = $this->login_m->dataPengguna($user);

        $this->db->select('*');
        $this->db->from('unit');
        $this->db->from('model');
        $this->db->from('project');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('unit.id_project = "' . $pengguna->id_project . '"');

        $query = $this->db->get();
        return $query->num_rows();
    }

    function insert($set)
    {
        $this->db->insert('unit', $set);
    }

    function insert_rep($set)
    {
        $this->db->insert('replacement', $set);
    }

    function insert_sos($set)
    {
        $this->db->insert('sos', $set);
    }

    function insert_ins($set)
    {
        $this->db->insert('inspection', $set);
    }

    function delete($id)
    {
        $table = array('unit');
        $this->db->where('id_unit', $id);
        $this->db->delete($table);
    }

    function delete_replacement($id)
    {
        $this->db->where('id_rep', $id);
        $this->db->delete('replacement');
    }

    function delete_sos($id)
    {
        $this->db->where('id_sos', $id);
        $this->db->delete('sos');
    }

    function delete_ins($id)
    {
        $this->db->where('id_ins', $id);
        $this->db->delete('inspection');
    }

    function update($id)
    {
        $this->db->where('id_unit', $id)->update('unit', $_POST);
    }

    function edit_rep($id)
    {
        $this->db->where('id_rep', $id)->update('replacement', $_POST);
    }

    function edit_sos($id)
    {
        $this->db->where('id_sos', $id)->update('sos', $_POST);
    }

    function edit_ins($id)
    {
        $this->db->where('id_ins', $id)->update('inspection', $_POST);
    }

    function select($id)
    {
        $this->db->select('*');
        $this->db->from('unit u');
        $this->db->join('model m', 'u.id_model = m.id_model', 'left');
        $this->db->join('project p', 'u.id_project = p.id_project', 'left');
        $this->db->join('commod cm', 'm.id_model = cm.id_model', 'left');
        $this->db->join('comp c', 'cm.id_comp = c.id_comp', 'left');
        $this->db->where(array('u.id_unit' => $id));
        $id = $this->db->get()->row();
        return $id;
    }

    function select_mod($id, $id_mod)
    {
        $this->db->select('*');
        $this->db->from('unit, model, project, commod, comp');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $this->db->where(array('unit.id_unit' => $id));
        $this->db->where(array('commod.id_mod' => $id_mod));
        $id = $this->db->get()->row();
        return $id;
    }

    function select_rep($id, $id_mod)
    {
        $this->db->select('*');
        $this->db->from('replacement, unit, hm, model, project, commod, comp');
        $this->db->where('replacement.id_unit = unit.id_unit');
        $this->db->where('replacement.id_mod = commod.id_mod');
        $this->db->where('hm.id_unit = unit.id_unit');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $this->db->where(array('replacement.id_unit' => $id));
        $this->db->where(array('replacement.id_mod' => $id_mod));
        $this->db->order_by('replacement.id_rep', 'desc');
        $id = $this->db->get()->result();
        return $id;
    }

    function select_reps($id, $id_mod)
    {
        $this->db->select('*');
        $this->db->from('replacement, unit, model, project, commod, comp');
        $this->db->where('replacement.id_unit = unit.id_unit');
        $this->db->where('replacement.id_mod = commod.id_mod');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $this->db->where(array('replacement.id_unit' => $id));
        $this->db->where(array('replacement.id_mod' => $id_mod));
        $this->db->order_by('replacement.id_rep', 'desc');
        $id = $this->db->get()->result_array();
        return $id;
    }

    function select_sos($id, $id_mod)
    {
        $this->db->select('*');
        $this->db->from('sos, unit, model, project, commod, comp');
        $this->db->where('sos.id_unit = unit.id_unit');
        $this->db->where('sos.id_mod = commod.id_mod');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $this->db->where(array('sos.id_unit' => $id));
        $this->db->where(array('sos.id_mod' => $id_mod));
        $this->db->order_by('sos.id_sos', 'desc');
        $id = $this->db->get()->result_array();
        return $id;
    }

    function select_4_sos($id, $id_mod)
    {
        $this->db->select('*');
        $this->db->from('sos');
        $this->db->where(array('sos.id_unit' => $id));
        $this->db->where(array('sos.id_mod' => $id_mod));
        $this->db->order_by('sos.sample_date', 'desc');
        $this->db->limit(4);
        $id = $this->db->get()->result();
        return $id;
    }

    function select_ins_f($id, $id_mod)
    {
        $this->db->select('*');
        $this->db->from('inspection, unit, model, project, commod, comp');
        $this->db->where('inspection.id_unit = unit.id_unit');
        $this->db->where('inspection.id_mod = commod.id_mod');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $this->db->where(array('inspection.id_unit' => $id));
        $this->db->where(array('inspection.id_mod' => $id_mod));
        $this->db->where(array('inspection.type' => 'FC'));
        $this->db->order_by('inspection.id_ins', 'desc');
        $id = $this->db->get()->result_array();
        return $id;
    }

    function select_4_fc($id, $id_mod)
    {
        $this->db->select('*');
        $this->db->from('inspection');
        $this->db->where(array('inspection.id_unit' => $id));
        $this->db->where(array('inspection.id_mod' => $id_mod));
        $this->db->where(array('inspection.type' => 'FC'));
        $this->db->order_by('inspection.ins_date', 'desc');
        $this->db->limit(4);
        $id = $this->db->get()->result();
        return $id;
    }

    function select_ins_m($id, $id_mod)
    {
        $this->db->select('*');
        $this->db->from('inspection, unit, model, project, commod, comp');
        $this->db->where('inspection.id_unit = unit.id_unit');
        $this->db->where('inspection.id_mod = commod.id_mod');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $this->db->where(array('inspection.id_unit' => $id));
        $this->db->where(array('inspection.id_mod' => $id_mod));
        $this->db->where(array('inspection.type' => 'MPS'));
        $this->db->order_by('inspection.id_ins', 'desc');
        $id = $this->db->get()->result_array();
        return $id;
    }

    function select_4_mps($id, $id_mod)
    {
        $this->db->select('*');
        $this->db->from('inspection');
        $this->db->where(array('inspection.id_unit' => $id));
        $this->db->where(array('inspection.id_mod' => $id_mod));
        $this->db->where(array('inspection.type' => 'MPS'));
        $this->db->order_by('inspection.ins_date', 'desc');
        $this->db->limit(4);
        $id = $this->db->get()->result();
        return $id;
    }

    function select_ins_v($id, $id_mod)
    {
        $this->db->select('*');
        $this->db->from('inspection, unit, model, project, commod, comp');
        $this->db->where('inspection.id_unit = unit.id_unit');
        $this->db->where('inspection.id_mod = commod.id_mod');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $this->db->where(array('inspection.id_unit' => $id));
        $this->db->where(array('inspection.id_mod' => $id_mod));
        $this->db->where(array('inspection.type' => 'VI'));
        $this->db->order_by('inspection.id_ins', 'desc');
        $id = $this->db->get()->result_array();
        return $id;
    }

    function select_4_vi($id, $id_mod)
    {
        $this->db->select('*');
        $this->db->from('inspection');
        $this->db->where(array('inspection.id_unit' => $id));
        $this->db->where(array('inspection.id_mod' => $id_mod));
        $this->db->where(array('inspection.type' => 'VI'));
        $this->db->order_by('inspection.ins_date', 'desc');
        $this->db->limit(4);
        $id = $this->db->get()->result();
        return $id;
    }

    function select_ins_t($id, $id_mod)
    {
        $this->db->select('*');
        $this->db->from('inspection, unit, model, project, commod, comp');
        $this->db->where('inspection.id_unit = unit.id_unit');
        $this->db->where('inspection.id_mod = commod.id_mod');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $this->db->where(array('inspection.id_unit' => $id));
        $this->db->where(array('inspection.id_mod' => $id_mod));
        $this->db->where(array('inspection.type' => 'TA2'));
        $this->db->order_by('inspection.id_ins', 'desc');
        $id = $this->db->get()->result_array();
        return $id;
    }

    function select_4_ta2($id, $id_mod)
    {
        $this->db->select('*');
        $this->db->from('inspection');
        $this->db->where(array('inspection.id_unit' => $id));
        $this->db->where(array('inspection.id_mod' => $id_mod));
        $this->db->where(array('inspection.type' => 'TA2'));
        $this->db->order_by('inspection.ins_date', 'desc');
        $this->db->limit(4);
        $id = $this->db->get()->result();
        return $id;
    }

    function select_ins_e($id, $id_mod)
    {
        $this->db->select('*');
        $this->db->from('inspection, unit, model, project, commod, comp');
        $this->db->where('inspection.id_unit = unit.id_unit');
        $this->db->where('inspection.id_mod = commod.id_mod');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $this->db->where(array('inspection.id_unit' => $id));
        $this->db->where(array('inspection.id_mod' => $id_mod));
        $this->db->where(array('inspection.type' => 'ED'));
        $this->db->order_by('inspection.id_ins', 'desc');
        $id = $this->db->get()->result_array();
        return $id;
    }

    function select_4_ed($id, $id_mod)
    {
        $this->db->select('*');
        $this->db->from('inspection');
        $this->db->where(array('inspection.id_unit' => $id));
        $this->db->where(array('inspection.id_mod' => $id_mod));
        $this->db->where(array('inspection.type' => 'ED'));
        $this->db->order_by('inspection.ins_date', 'desc');
        $this->db->limit(4);
        $id = $this->db->get()->result();
        return $id;
    }

    function get_sos($id)
    {
        $this->db->select('*');
        $this->db->from('sos, unit, model, project, commod, comp');
        $this->db->where('sos.id_unit = unit.id_unit');
        $this->db->where('sos.id_mod = commod.id_mod');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $this->db->where(array('sos.id_sos' => $id));
        $id = $this->db->get()->row_array();
        return $id;
    }

    function get_ins_f($id)
    {
        $this->db->select('*');
        $this->db->from('inspection, unit, model, project, commod, comp');
        $this->db->where('inspection.id_unit = unit.id_unit');
        $this->db->where('inspection.id_mod = commod.id_mod');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $this->db->where(array('inspection.id_ins' => $id));
        $this->db->where(array('inspection.type' => 'FC'));
        $id = $this->db->get()->row_array();
        return $id;
    }

    function get_ins_m($id)
    {
        $this->db->select('*');
        $this->db->from('inspection, unit, model, project, commod, comp');
        $this->db->where('inspection.id_unit = unit.id_unit');
        $this->db->where('inspection.id_mod = commod.id_mod');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $this->db->where(array('inspection.id_ins' => $id));
        $this->db->where(array('inspection.type' => 'MPS'));
        $id = $this->db->get()->row_array();
        return $id;
    }

    function get_ins_v($id)
    {
        $this->db->select('*');
        $this->db->from('inspection, unit, model, project, commod, comp');
        $this->db->where('inspection.id_unit = unit.id_unit');
        $this->db->where('inspection.id_mod = commod.id_mod');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $this->db->where(array('inspection.id_ins' => $id));
        $this->db->where(array('inspection.type' => 'VI'));
        $id = $this->db->get()->row_array();
        return $id;
    }

    function get_ins_t($id)
    {
        $this->db->select('*');
        $this->db->from('inspection, unit, model, project, commod, comp');
        $this->db->where('inspection.id_unit = unit.id_unit');
        $this->db->where('inspection.id_mod = commod.id_mod');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $this->db->where(array('inspection.id_ins' => $id));
        $this->db->where(array('inspection.type' => 'TA2'));
        $id = $this->db->get()->row_array();
        return $id;
    }

    function get_ins_e($id)
    {
        $this->db->select('*');
        $this->db->from('inspection, unit, model, project, commod, comp');
        $this->db->where('inspection.id_unit = unit.id_unit');
        $this->db->where('inspection.id_mod = commod.id_mod');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $this->db->where(array('inspection.id_ins' => $id));
        $this->db->where(array('inspection.type' => 'ED'));
        $id = $this->db->get()->row_array();
        return $id;
    }

    function getInsByComp($id_unit, $id_mod)
    {
        return $this->db->query(
            "SELECT DISTINCT
        (SELECT A.rating FROM inspection A WHERE A.type = 'FC' AND A.id_unit = T0.id_unit AND A.id_mod = T0.id_mod ORDER BY ins_date DESC LIMIT 1) as 'FC',
        (SELECT A.rating FROM inspection A WHERE A.type = 'MPS' AND A.id_unit = T0.id_unit AND A.id_mod = T0.id_mod ORDER BY ins_date DESC LIMIT 1) as 'MPS',
        (SELECT A.rating FROM inspection A WHERE A.type = 'VI' AND A.id_unit = T0.id_unit AND A.id_mod = T0.id_mod ORDER BY ins_date DESC LIMIT 1) as 'VI',
        (SELECT A.rating FROM inspection A WHERE A.type = 'TA2' AND A.id_unit = T0.id_unit AND A.id_mod = T0.id_mod ORDER BY ins_date DESC LIMIT 1) as 'TA2',
        (SELECT A.rating FROM inspection A WHERE A.type = 'ED' AND A.id_unit = T0.id_unit AND A.id_mod = T0.id_mod ORDER BY ins_date DESC LIMIT 1) as 'ED'
        FROM inspection T0
        WHERE id_unit = $id_unit AND id_mod = $id_mod"
        )->row();
    }

    function getSosByComp($id_unit, $id_mod)
    {
        return $this->db->query(
            "SELECT DISTINCT
        (SELECT A.eval_code FROM sos A WHERE A.type = 'SOS' AND A.id_unit = T0.id_unit AND A.id_mod = T0.id_mod ORDER BY sample_date DESC LIMIT 1) as 'SOS'
        FROM sos T0
        WHERE id_unit = $id_unit AND id_mod = $id_mod"
        )->row();
    }

    function getRatingInsByComp($id_unit, $id_mod)
    {
        return $this->db->query(
            "select type, rating
        from inspection a
        where a.ins_date = (
                select max(ins_date)
            from inspection b
            where a.type = b.type and a.id_unit = b.id_unit and a.id_mod = b.id_mod
        ) and a.id_unit = $id_unit and a.id_mod = $id_mod"
        )->result_array();
    }

    function getRatingSosByComp($id_unit, $id_mod)
    {
        return $this->db->query(
            "select type,eval_code 
        from sos c
        where c.sample_date = (
                select max(sample_date)
                from sos d
                where c.type = d.type and c.id_unit = d.id_unit and c.id_mod = d.id_mod
        ) and c.id_unit = $id_unit and c.id_mod = $id_mod"
        )->result_array();
    }

    //    function getRatingSosByComp($id_unit, $id_mod) {
    //        return $this->db->query(
    //        "select type,eval_code from sos c where c.id_unit = $id_unit and c.id_mod = $id_mod order by sample_date desc limit 1"
    //        )->row();
    //    }

    function select_reps_asc($id, $id_mod)
    {
        $this->db->select('*');
        $this->db->from('replacement, unit, model, project, commod, comp');
        $this->db->where('replacement.id_unit = unit.id_unit');
        $this->db->where('replacement.id_mod = commod.id_mod');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $this->db->where(array('replacement.id_unit' => $id));
        $this->db->where(array('replacement.id_mod' => $id_mod));
        $this->db->order_by('replacement.id_rep', 'asc');
        $id = $this->db->get()->result_array();
        return $id;
    }

    function num_reps($id, $id_mod)
    {
        $this->db->select('*');
        $this->db->from('replacement, unit, model, project, commod, comp');
        $this->db->where('replacement.id_unit = unit.id_unit');
        $this->db->where('replacement.id_mod = commod.id_mod');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $this->db->where(array('replacement.id_unit' => $id));
        $this->db->where(array('replacement.id_mod' => $id_mod));
        $this->db->order_by('replacement.id_rep', 'desc');
        $id = $this->db->get()->num_rows();
        return $id;
    }

    function last_rep($id, $id_mod)
    {
        $this->db->select('*');
        $this->db->from('replacement, unit, model, project, commod, comp');
        $this->db->join('hm', 'hm.id_unit = unit.id_unit', 'left');
        $this->db->where('replacement.id_unit = unit.id_unit');
        $this->db->where('replacement.id_mod = commod.id_mod');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $this->db->where(array('replacement.id_unit' => $id));
        $this->db->where(array('replacement.id_mod' => $id_mod));
        $this->db->order_by('hm.id_hm', 'desc');
        $this->db->order_by('replacement.id_rep', 'desc');
        $this->db->limit(1);
        $id = $this->db->get()->row();
        return $id;
    }

    function last_rep_close($id, $id_mod)
    {
        $this->db->select('*');
        $this->db->from('replacement, unit, model, project, commod, comp');
        $this->db->join('hm', 'hm.id_unit = unit.id_unit', 'left');
        $this->db->where('replacement.id_unit = unit.id_unit');
        $this->db->where('replacement.id_mod = commod.id_mod');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $this->db->where(array('replacement.id_unit' => $id));
        $this->db->where(array('replacement.id_mod' => $id_mod));
        $this->db->where('replacement.wo_status = "CLOSE"');
        $this->db->order_by('hm.id_hm', 'desc');
        $this->db->order_by('replacement.id_rep', 'desc');
        $this->db->limit(1);
        $id = $this->db->get()->row();
        return $id;
    }

    function get_rep($id)
    {
        $this->db->select('*');
        $this->db->from('replacement, unit, model, project, commod, comp');
        $this->db->where('replacement.id_unit = unit.id_unit');
        $this->db->where('replacement.id_mod = commod.id_mod');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $this->db->where(array('replacement.id_rep' => $id));
        $this->db->order_by('replacement.id_rep', 'desc');
        $id = $this->db->get()->row();
        return $id;
    }

    function get_comp($id)
    {
        $this->db->select('*');
        $this->db->from('unit, model, project, commod, comp');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $this->db->where('comp.status = "Active"');
        $this->db->where(array('unit.id_unit' => $id));
        $id = $this->db->get()->result();
        return $id;
    }

    function getAllComp()
    {
        $this->db->select('*');
        $this->db->from('unit, model, project, commod, comp');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $id = $this->db->get()->result();
        return $id;
    }

    function getAvg($id)
    {
        return $this->db->query('
            select avg (wh_day) as "avg" 
            from hm where 
            date_hm <= curdate() 
            and date_hm >= (DATE_SUB(CURDATE(), INTERVAL 3 MONTH)) 
            and id_unit = ' . $id . '')->row();
    }

    function getCritical()
    {
        $this->db->select('*');
        $this->db->from('condition,unit, model, project, commod, comp');
        $this->db->where('condition.id_unit = unit.id_unit');
        $this->db->where('condition.id_mod = commod.id_mod');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $this->db->where(array('condition.condition' => 'CRITICAL'));
        return $query = $this->db->get();
    }

    function select_model($id)
    {
        $this->db->select('id_model');
        $this->db->from('unit');
        $this->db->where(array('id_unit' => $id));
        $id = $this->db->get()->row_array();
        return $id;
    }

    function select_project($id)
    {
        $this->db->select('id_project');
        $this->db->from('unit');
        $this->db->where(array('id_unit' => $id));
        $id = $this->db->get()->row_array();
        return $id;
    }

    function select_status($id)
    {
        $this->db->select('wo_status');
        $this->db->from('replacement');
        $this->db->where(array('id_rep' => $id));
        $id = $this->db->get()->row_array();
        return $id;
    }

    function select_code($id)
    {
        $this->db->select('eval_code');
        $this->db->from('sos');
        $this->db->where(array('id_sos' => $id));
        $id = $this->db->get()->row_array();
        return $id;
    }

    function select_rating($id)
    {
        $this->db->select('rating');
        $this->db->from('inspection');
        $this->db->where(array('id_ins' => $id));
        $id = $this->db->get()->row_array();
        return $id;
    }

    function select_hm($id)
    {
        $this->db->select('*');
        $this->db->from('unit');
        $this->db->join('hm', 'hm.id_unit = unit.id_unit', 'left');
        $this->db->where(array('hm.id_unit' => $id));
        $this->db->order_by('id_hm', 'desc');
        $id = $this->db->get()->row();
        return $id;
    }

    function getHM()
    {
        return $this->db->query(
            'SELECT h.id_unit, u.unit_no, h.hm_unit, h.wh_day, maxDate as last_hm_date FROM hm h
INNER JOIN 
(SELECT id_unit, max(date_hm) as maxDate from hm group by id_unit) a
ON a.id_unit = h.id_unit AND a.maxDate = h.date_hm
LEFT JOIN unit u ON h.id_unit = u.id_unit
ORDER BY h.id_unit ASC'
        )->result_array();
    }

    function dashboard_pcr()
    {
        $this->db->select('*');
        $this->db->from('replacement, unit, model, project, commod, comp');
        $this->db->join('hm', 'hm.id_unit = unit.id_unit', 'left');
        $this->db->where('replacement.id_unit = unit.id_unit');
        $this->db->where('replacement.id_mod = commod.id_mod');
        $this->db->where('unit.id_model = model.id_model');
        $this->db->where('unit.id_project = project.id_project');
        $this->db->where('commod.id_model = model.id_model');
        $this->db->where('commod.id_comp = comp.id_comp');
        $this->db->where('replacement.wo_status = "OPEN"');
        $this->db->order_by('hm.id_hm', 'desc');
        $this->db->order_by('replacement.id_rep', 'desc');
        $id = $this->db->get()->result();
        return $id;
    }
}
